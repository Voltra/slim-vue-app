<?php

namespace App\Actions;

use App\Events\Events;
use App\Events\User\UserCreated;
use App\Events\User\UserLoggedIn;
use App\Events\User\UserLoggedOut;
use App\Exceptions\CannotRegisterUser;
use App\Exceptions\Invalid2FA;
use App\Exceptions\InvalidLoginAttempt;
use App\Exceptions\InvalidRememberLogin;
use App\Exceptions\ReplayAttack2FA;
use App\Exceptions\UserDoesNotExist;
use App\Helpers\UserResponsePair;
use App\Models\User;
use App\Models\UserRemember;
use Carbon\Carbon;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\QueryException;
use Psr\Http\Message\ServerRequestInterface;
use DI\Container;
use Slim\Psr7\Response;

class Auth extends Action
{
	protected $sessionKey, $cookieName, $cookieExpiry, $separator, $containerKey;

	/**@var Hash $hash*/
	protected $hash;

	/**@var Cookies $cookies*/
	protected $cookies;

	/**@var Random $random*/
	protected $random;

	/**@var \App\Helpers\Session $session*/
	protected $session;
	/**
	 * @var TwoFactor
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

		$this->hash = $container->get(Hash::class);
		$this->cookies = $container->get(Cookies::class);
		$this->random = $container->get(Random::class);
		$this->tfa = $container->get(TwoFactor::class);

		if (!$this->user())
			$this->container->set($this->containerKey, null);
	}

	/**
	 * Determines whether or not a user is logged in
	 * @return bool
	 * @throws DependencyException
	 * @throws NotFoundException
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
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function user(): ?User
	{
		$this->syncContainerAndSession();
		if ($this->isLoggedIn())
			return $this->container->get($this->containerKey);
		return null;
	}

	/**
	 * Determine whether or not the logged in user is admin
	 * @return bool
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
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
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function isLoggedAs(string $username): bool
	{
		$this->syncContainerAndSession();
		if (!$this->isLoggedIn())
			return false;

		$user = $this->user();
		return $user->username === $username;
	}

	/**
	 * Handle 2FA checks
	 * @param User $user - The user to handle 2FA for
	 * @param string $code - The submitted code
	 * @throws ReplayAttack2FA
	 * @throws Invalid2FA
	 */
	public function handle2FA(User $user, string $code): void{
		if(!$user->requires2FA())
			return;

		/**
		 * @var \App\Models\TwoFactor $tfa
		 */
		$tfa = $user->twoFactor;

		if($code === $tfa->latest_code) // avoid code replay
			throw new ReplayAttack2FA();

		$isValid = $this->tfa->validate($user, $code);
		if(!$isValid)
			throw new Invalid2FA();

		$tfa->latest_code = $code; // avoid code replay
		$tfa->save();
	}

	/**
	 * Attempts to log in with the given credentials
	 * @param Response $res
	 * @param string $username
	 * @param string $password
	 * @param bool $remember
	 * @param bool $emitEvents
	 * @return UserResponsePair
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws UserDoesNotExist
	 * @throws InvalidLoginAttempt
	 */
	public function login(Response $res, string $username, string $password, bool $remember = false, bool $emitEvents = true): UserResponsePair
	{
		$this->syncContainerAndSession();
		$user = User::fromUsername($username);
		$shouldAccept = $user
			&& $this->hash->checkPassword($password, $user->password);

		if ($shouldAccept) {
			$ret = $this->logout($res, false);
			$this->container->set($this->containerKey, $user);

			if ($remember)
				$ret = $this->remember($ret);

			$this->syncContainerAndSession();
			Events::triggerIf($emitEvents, new UserLoggedIn($user));
			return new UserResponsePair($ret, $user);
		}else if($user === null)
			throw new UserDoesNotExist();
		else
			throw new InvalidLoginAttempt();
	}

	/**
	 * Setup client data to remember the logged in user
	 * @param Response $res - The current response
	 * @return Response
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws UserDoesNotExist
	 */
	public function remember(Response $res): Response
	{
		$this->syncContainerAndSession();
		$user = $this->user();

		if ($user === null)
			throw new UserDoesNotExist();

		$id = $this->random->generateString();
		$token = $this->random->generateString();
		$user->updateRemember($id, $this->hash->hash($token));

		$cookie = $this->cookies->builder($this->cookieName)
			->withValue("{$id}{$this->separator}{$token}")
			->withExpires(Carbon::parse($this->cookieExpiry))
			->withHttpOnly(true);

		return $this->cookies->set($res, $cookie);
	}

	/**
	 * Forces login with the given username
	 * @param Response $res
	 * @param string $username
	 * @param bool $emitEvents
	 * @return UserResponsePair
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws UserDoesNotExist
	 */
	public function forceLogin(Response $res, string $username, bool $emitEvents = true): UserResponsePair
	{
		$this->syncContainerAndSession();
		$user = User::fromUsername($username);

		if($user === null)
			throw new UserDoesNotExist();

		$ret = $this->logout($res, false);
		$this->container->set($this->containerKey, $user);
		$this->syncContainerAndSession();

		Events::triggerIf($emitEvents, new UserLoggedIn($user));

		return new UserResponsePair($ret, $user);
	}

	/**
	 * Logs out the current user
	 * @param Response $res
	 * @param bool $emitEvents
	 * @return Response
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function logout(Response $res, bool $emitEvents = true): Response
	{
		$user = $this->user();
		$ret = $this->cleanup($res);

		Events::triggerIf($emitEvents && $user !== null, new UserLoggedOut($user));

		return $ret;
	}

	/**
	 * Register a new user
	 * @param Response $res
	 * @param string $email
	 * @param string $username
	 * @param string $password
	 * @param bool $remember
	 * @param bool $emitEvents
	 * @return UserResponsePair
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws CannotRegisterUser
	 * @throws UserDoesNotExist
	 * @throws InvalidLoginAttempt
	 */
	public function register(Response $res, string $email, string $username, string $password, bool $remember = false, bool $emitEvents = true): UserResponsePair
	{
		$this->syncContainerAndSession();
		try {
			$user = User::make($email, $username, $this->hash->hashPassword($password));

			Events::triggerIf($emitEvents, new UserCreated($user));
		} catch (QueryException $e) {
			throw new CannotRegisterUser();
		}

		return $this->login($res, $username, $password, $remember);
	}

	/**
	 * Attempt to login from remember credentials in a cookie
	 * @param ServerRequestInterface $rq
	 * @param Response $res
	 * @param bool $emitEvents
	 * @return UserResponsePair
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws InvalidRememberLogin
	 * @throws UserDoesNotExist
	 */
	public function loginFromRemember(ServerRequestInterface $rq, Response $res, bool $emitEvents = true): UserResponsePair
	{
		$this->syncContainerAndSession();
		$hasCookie = $this->cookies->has($rq, $this->cookieName);
		if (!$hasCookie || $this->isLoggedIn())
			return new UserResponsePair($res, $this->user());

		/**@var string $cookie*/
		$cookie = $this->cookies->get($rq, $this->cookieName)->getValue();
		$credentials = explode($this->separator, $cookie);

		if (empty(trim($cookie)) || count($credentials) !== 2)
			throw new InvalidRememberLogin();

		[$id, $token] = $credentials;
		$hashedToken = $this->hash->hash($token);
		$rem = UserRemember::fromRID($id);

		if($rem === null)
			throw new UserDoesNotExist();

		if (!$this->hash->checkHash($hashedToken, $rem->token()))
			throw new InvalidRememberLogin();

		$user = $rem->user;
		return $this->forceLogin($res, $user->username, $emitEvents);
	}

	protected function cleanup(Response $res){
		$ret = $this->cookies->expire($res, $this->cookieName);
		//		$ret = $this->cookies->remove($res, $this->cookieName);
		$this->session->delete($this->sessionKey);
		$this->container->set($this->containerKey, null); //TODO: Find a way to remove from container
		return $ret;
	}

	/**
	 * Syncs the container state's with the session's
	 * @throws DependencyException
	 * @throws NotFoundException
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
}
