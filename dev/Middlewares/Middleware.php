<?php
namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Response;

abstract class Middleware {
	/**@var Container $container*/
	protected $container;

	public function __invoke(ServerRequestInterface $rq, Response $res, callable $next): ResponseInterface{
		return $this->process($rq, $res, $next);
	}

	public abstract function process(ServerRequestInterface $rq, Response $res, callable $next): ResponseInterface;

	public static function from(...$args){
		return new static(...$args);
	}

	public function __construct(Container $container){
		$this->container = $container;
	}
}