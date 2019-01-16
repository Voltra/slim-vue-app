<?php
namespace App\Filters;


use App\Actions\Auth;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use Slim\Router;

abstract class Filter {
	/**@var Container $container*/
	protected $container;

	/**@var Router $router*/
	protected $router;

	/**@var Auth $auth*/
	protected $auth;

	public function __construct(ContainerInterface $c) {
		$this->container = $c;
		$this->router = $c->get("router");
		$this->auth = $c->get(Auth::class);
	}

	public static function from(...$args){
		return new static(...$args);
	}

	protected abstract function isAuthorized(): bool;

	protected function redirectURL(): string{
		return $this->router->pathFor("home");
	}

	protected function redirectStatus(): int{
//		return StatusCode::HTTP_FORBIDDEN;
		return StatusCode::HTTP_TEMPORARY_REDIRECT;
	}

	public function __invoke(Request $rq, Response $res, callable $next): Response{
		if(!$this->isAuthorized(/*$this->container*/))
			return $res->withRedirect($this->redirectURL(), $this->redirectStatus());

		return $next($rq, $res);
	}

	public function composeWith(Filter $rhs): ComposedFilter{
		return ComposedFilter::from($this->container, $this, $rhs);
	}
}