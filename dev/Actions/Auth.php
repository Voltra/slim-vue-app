<?php

namespace App\Actions;

use App\Helpers\UserResponsePair;
use App\Models\User;
use App\Models\UserRemember;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ServerRequestInterface;
use DI\Container;
use Slim\Psr7\Response;
use SlimSession\Helper as Session;

class Auth extends Action
{
	protected $sessionKey, $cookieName, $cookieExpiry, $separator, $containerKey;

	/**@var Hash $hash*/
	protected $hash;

	/**@var Cookies $cookies*/
	protected $cookies;

	/**@var Random $random*/
	protected $random;

	/**@var Session $session*/
	protected $session;
	/**
	 * @var TwoFactor|mixed
	 */
	protected $tfa;

	public function __construct(Container $container)
	{
		parent::__construct($container);
		$config = $container->get("config")["auth"];

		$this->sessionKey = $config["session"];
		$this->cookieName = $config["remember_name"];
		$this->cookieExpiry = $config["remember_exp"];
		$this->separator = $config["cookie_separator"];
		$this->containerKey = $config["container"];
		$this->session = $container->get("session");

		$this->hash = $container->get(Hash::class);
		$this->cookies = $container->get(Cookies::class);
		$this->random = $container->get(Random::class);
		$this->tfa = $container->get(TwoFactor::class);

		if (!$this->user())
			$this->container->set($this->containerKey, null);
	}

	/**
	 * Syncs the container state's with the session's
	 */
	protected function syncContainerAndSession(): void
	{
		if ($this->session->exists($this->sessionKey))
			//always sync in case of user hotswap
			$this->container->set(
				$this->containerKey,
				User::find($this->session->get($this->sessionKey))
			);
		else if ($this->container->has($this->containerKey)){
			$user = $this->container->get($this->containerKey);
			if($user === null)
				return; //temp fix because interfaces do not have a way to delete from containers

			$this->session->set($this->sessionKey, $user->id);
		}
	}

	/**
	 * Determines whether or not a user is logged in
	 * @return bool
	 * @throws ContainerException
	 */
	public function isLoggedIn(): bool
	{
		$this->syncContainerAndSession();
		return $this->container->has($this->containerKey)
			&& !empty($this->container->get($this->containerKey));
	}

	/**
	 * Fetches the current logged in user
	 * @return User|null
	 * @throws ContainerException
	 */
	public function user(): ?User
	{
		$this->syncContainerAndSession();
		if ($this->isLoggedIn())
			return $this->container->get($this->containerKey);
		return null;
	}

	public function isAdmin(): bool
	{
		if (!$this->isLoggedIn())
			return false;

		return $this->user()->isAdmin();
	}

	/**
	 * Determines whether or not the user is logged as the on with the given username
	 * @param string $username
	 * @return bool
	 * @throws ContainerException
	 */
	public function isLoggedAs(string $username): bool
	{
		$this->syncContainerAndSession();
		if (!$this->isLoggedIn())
			return false;

		$user = $this->user();
		return $user->username === $username;
	}

	public function handle2FA(User $user, string $code): bool{
		//TODO: Throw exception when trying to replay code
		//TODO: Throw exception when code is invalid

		if(!$user->requires2FA())
			return true;

		/**
		 * @var \App\Models\TwoFactor $tfa
		 */
		$tfa = $user->twoFactor;

		if($code === $tfa->latest_code) // avoid code replay
			return false;

		$isValid = $this->tfa->validate($user, $code);
		if($isValid){
			$tfa->latest_code = $code; // avoid code replay
			$tfa->save();
			return true;
		}

		return false;
	}

	/**
	 * Attempts to log in with the given credentials
	 * @param Response $res
	 * @param string $username
	 * @param string $password
	 * @param bool $remember
//	 * @param string $tfaCode
	 * @return UserResponsePair
	 */
	public function login(Response $res, string $username, string $password, bool $remember = false/*, string $tfaCode = ""*/): UserResponsePair
	{
		$this->syncContainerAndSession();
		$user = User::fromUsername($username);
		$shouldAccept = $user
			&& $this->hash->checkPassword($password, $user->password)
			/*&& $this->handle2FA($user, $tfaCode)*/;

		if ($shouldAccept) {
			$ret = $this->logout($res);
			$this->container->set($this->containerKey, $user);

			if ($remember)
				$ret = $this->remember($ret);

			$this->syncContainerAndSession();
			return new UserResponsePair($ret, $user);
		}

		return new UserResponsePair($res, null);
	}

	public function remember(Response $res): Response
	{
		$this->syncContainerAndSession();
		$user = $this->user();

		if ($user === null)
			return $res;

		$id = $this->random->generateString();
		$token = $this->random->generateString();
		$user->updateRemember($id, $this->hash->hash($token));

		$cookie = $this->cookies->builder($this->cookieName)
			->withValue("{$id}{$this->separator}{$token}")
			->withExpires(Carbon::parse($this->cookieExpiry)->timestamp)
			->withHttpOnly(true);

		return $this->cookies->set($res, $cookie);
	}

	/**
	 * Forces login with the given username
	 * @param Response $res
	 * @param string $username
	 * @return UserResponsePair
	 */
	public function forceLogin(Response $res, string $username): UserResponsePair
	{
		$this->syncContainerAndSession();
		$user = User::fromUsername($username);
		$ret = $res;

		if ($user) {
			$ret = $this->logout($res);
			$this->container->set($this->containerKey, $user);
			$this->syncContainerAndSession();
		}

		return new UserResponsePair($ret, $user);
	}

	/**
	 * Logs out the current user
	 * @param Response $res
	 * @return Response
	 */
	public function logout(Response $res): Response
	{
		$res = $this->cookies->expire($res, $this->cookieName);
		//		$res = $this->cookies->remove($res, $this->cookieName);
		$this->session->delete($this->sessionKey);
		$this->container->set($this->containerKey, null); //TODO: Find a way to remove from container
		return $res;
	}

	/**
	 * Register a new user
	 * @param Response $res
	 * @param string $email
	 * @param string $username
	 * @param string $password
	 * @param bool $remember
	 * @return UserResponsePair
	 */
	public function register(Response $res, string $email, string $username, string $password, bool $remember = false): UserResponsePair
	{
		$this->syncContainerAndSession();
		try {
			$user = User::make($email, $username, $this->hash->hashPassword($password));
		} catch (QueryException $e) {
			return new UserResponsePair($res, null);
		}
		return $this->login($res, $username, $password, $remember);
	}

	/**
	 * Attempt to login from remember credentials in a cookie
	 * @param ServerRequestInterface $rq
	 * @param Response $res
	 * @return UserResponsePair
	 * @throws ContainerException
	 */
	public function loginfromRemember(ServerRequestInterface $rq, Response $res): UserResponsePair
	{
		$this->syncContainerAndSession();
		$hasCookie = $this->cookies->has($rq, $this->cookieName);
		if (!$hasCookie || $this->isLoggedIn())
			return new UserResponsePair($res, $this->user());

		/**@var string $cookie*/
		$cookie = $this->cookies->get($rq, $this->cookieName)->getValue();
		$credentials = explode($this->separator, $cookie);
		$emptyRes = new UserResponsePair($res, null);

		if (empty(trim($cookie)) || count($credentials) !== 2)
			return $emptyRes;

		[$id, $token] = $credentials;
		$hashedToken = $this->hash->hash($token);
		$rem = UserRemember::fromRID($id);

		if ($rem === null || !$this->hash->checkHash($hashedToken, $rem->token()))
			return $emptyRes;

		$user = $rem->user;
		return $this->forceLogin($res, $user->username);
	}
}
