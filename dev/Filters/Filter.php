<?php

namespace App\Filters;


use App\Actions\Auth;
use App\Middlewares\Middleware;
use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

//TODO: Rework to use Slim4 middlewares

abstract class Filter extends Middleware
{
	/**@var RouteParserInterface $router*/
	protected $router;

	/**@var Auth $auth*/
	protected $auth;

	public function __construct(ContainerInterface $c)
	{
		parent::__construct($c);
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
		return $this->router->urlFor("home");
	}

	protected function redirectStatus(): int
	{
		//		return Httpstatuscodes::HTTP_FORBIDDEN;
		return Httpstatuscodes::HTTP_TEMPORARY_REDIRECT;
	}

	public function process(ServerRequestInterface $req, RequestHandlerInterface $handler): ResponseInterface
	{
		if (!$this->isAuthorized()) {
			$res = new Response();
			return $this->responseUpgrader->redirect(
				$res,
				$this->redirectURL(),
				$this->redirectStatus()
			);
		}

		return $handler->handle($req);
	}

	public function composeWith(Filter $rhs): ComposedFilter
	{
		return ComposedFilter::from($this->container, $this, $rhs);
	}
}

/**
 * Resolve a route filter
 * @param $filterClass - The classname of the filter
 * @return Filter
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function filter($filterClass){
	return resolve($filterClass);
}
