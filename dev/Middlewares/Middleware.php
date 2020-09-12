<?php

namespace App\Middlewares;


use App\Actions\Response as ResponseUpgrader;
use Middlewares\Utils\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

abstract class Middleware implements MiddlewareInterface
{
	/**@var Container $container*/
	protected $container;

	/**
	 * @var ResponseUpgrader $responseUpgrader
	 */
	protected $responseUpgrader;

	public function __invoke(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		return $this->process($req, $handler);
	}

	public abstract function process(Request $req, RequestHandlerInterface $handler): ResponseInterface;

	public static function from(...$args)
	{
		return new static(...$args);
	}

	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->responseUpgrader = $container->get(ResponseUpgrader::class);
	}
}
