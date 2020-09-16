<?php

namespace App\Middlewares;


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


	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		//TODO: Check if this still works after migrating to SlimV4 middlewares

		$rawResponse = $handler->handle($req);
		$response = $this->responseUpgrader->upgrade($rawResponse);
		return $this->auth->loginfromRemember($req, $response)->response;
	}
}
