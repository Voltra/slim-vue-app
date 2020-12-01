<?php

namespace App\Middlewares;


use App\Exceptions\InvalidRememberLogin;
use Psr\Http\Message\ResponseInterface;
use App\Actions\Auth as AuthAction;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class Auth extends Middleware
{
	/**@var AuthAction $auth*/
	protected $auth;

	public function __construct(Container $container, ?AuthAction $auth = null)
	{
		parent::__construct($container);
		$this->auth = $auth ?? $container->get(AuthAction::class);
	}


	/**
	 * @param Request $req
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws InvalidRememberLogin
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		//TODO: Check if this still works after migrating to SlimV4 middlewares

		$rawResponse = $handler->handle($req);
		$response = $this->responseUtils->upgrade($rawResponse);
		return $this->auth->loginFromRemember($req, $response)->response;
	}
}
