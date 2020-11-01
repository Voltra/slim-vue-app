<?php


namespace App\Middlewares;


use App\Actions\TwoFactor;
use App\Exceptions\Invalid2FA;
use App\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class Requires2FA extends Middleware
{

	/**
	 * @var \App\Actions\Auth
	 */
	protected $auth;

	/**
	 * @var TwoFactor
	 */
	protected $tfa;

	/**
	 * @var string
	 */
	protected $codeKey;

	/**
	 * @var string
	 */
	protected $usernameKey;

	public function __construct(ContainerInterface $container, array $keys = [])
	{
		parent::__construct($container);
		$this->auth = $container->get(\App\Actions\Auth::class);

		$this->usernameKey = $keys["username"] ?? "username";
		$this->codeKey = $keys["code"] ?? "2fa";
	}

	/**
	 * @param Request $req
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws Invalid2FA
	 */
	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
    {
    	$body = $req->getParsedBody();
    	$res = !$this->auth->isLoggedIn()
		? $this->whenNotLoggedIn($req, $body)
		: $this->whenLoggedIn($req, $body);

    	return $res ?? $handler->handle($req);
    }

	/**
	 * @param Request $req
	 * @param array|null|object $body
	 * @return ResponseInterface|null
	 * @throws Invalid2FA
	 */
	protected function whenNotLoggedIn(Request $req, $body): ?ResponseInterface
	{
		//TODO: See if we should prefer a legit login (w/ all parameters) instead of a forced on
		$username = $body[$this->usernameKey] ?? "";
		$user = $this->auth->forceLogin(new Response(), $username)->user;
		$this->auth->logout(new Response());

		return $user !== null ? $this->handleForUser($user, $body) : null;
	}

	/**
	 * @param Request $req
	 * @param array|null|object $body
	 * @return ResponseInterface|null
	 * @throws Invalid2FA
	 */
	protected function whenLoggedIn(Request $req, $body): ?ResponseInterface
	{
		$user = $this->auth->user();
		return $this->handleForUser($user, $body);
	}

	/**
	 * @param User $user
	 * @param array|null|object $body
	 * @return ResponseInterface|null
	 * @throws Invalid2FA
	 */
	protected function handleForUser(User $user, $body): ?ResponseInterface{
		$code = $body[$this->codeKey] ?? "";
		$isValid = $this->auth->handle2FA($user, $code);

		if(!$isValid)
			throw new Invalid2FA();

		return null;
	}
}

/**
 * Utility to create a 2FA middleware
 * @param array $keys
 * @return Requires2FA
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function requires2FA(array $keys = []){
	$actualKeys = array_merge([], [
		"username" => "username",
		"code" => "2fa",
	], $keys);

	/**
	 * @var ContainerInterface $container
	 */
	$container = resolve(ContainerInterface::class);

	return new Requires2FA($container, $actualKeys);
}
