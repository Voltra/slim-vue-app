<?php
namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Actions\Auth as AuthAction;
use Slim\Container;
use Slim\Http\Response;

class Auth extends Middleware{
	/**@var AuthAction $auth*/
	protected $auth;

	public function __construct(Container $container, ?AuthAction $auth = null) {
		parent::__construct($container);
//		$this->auth = $auth ?? new AuthAction($container);
		$this->auth = $auth ?? $container->get(AuthAction::class);
	}

	public function process(ServerRequestInterface $rq, Response $res, callable $next): ResponseInterface {
		$response = $this->auth->loginfromRemember($rq, $res)->response;
		return $next($rq, $response);
	}
}