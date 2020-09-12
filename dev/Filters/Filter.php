<?php

namespace App\Filters;


use App\Actions\Auth;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Psr7\StatusCode;
use Slim\Router;

//TODO: Rework to use Slim4 middlewares

abstract class Filter
{
	/**@var Container $container*/
	protected $container;

	/**@var Router $router*/
	protected $router;

	/**@var Auth $auth*/
	protected $auth;

	public function __construct(ContainerInterface $c)
	{
		$this->container = $c;
		$this->router = $c->get("router");
		$this->auth = $c->get(Auth::class);
	}

	public static function from(...$args)
	{
		return new static(...$args);
	}

	public static function compose(string $lhs, string $rhs){}

	protected abstract function isAuthorized(): bool;

	protected function redirectURL(): string
	{
		return $this->router->pathFor("home");
	}

	protected function redirectStatus(): int
	{
		//		return StatusCode::HTTP_FORBIDDEN;
		return StatusCode::HTTP_TEMPORARY_REDIRECT;
	}

	public function __invoke(Request $rq, Response $res, callable $next): Response
	{
		if (!$this->isAuthorized())
			return $res->withRedirect($this->redirectURL(), $this->redirectStatus());

		return $next($rq, $res);
	}

	public function composeWith(Filter $rhs): ComposedFilter
	{
		return ComposedFilter::from($this->container, $this, $rhs);
	}
}
