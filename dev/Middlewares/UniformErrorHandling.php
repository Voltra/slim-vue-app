<?php


namespace App\Middlewares;


use LazyCollection\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class UniformErrorHandling extends Middleware
{

	/**
	 * @param Request $req
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws Throwable
	 */
	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		try{
			return $handler->handle($req);
		}catch(Throwable $e){
			$class = get_class($e);
			$handler = Stream::fromIterable([$class])
				->then(class_parents($class))
				->then(class_implements($class))
				->unique()
				->map(function($class){ return null; })
				->firstOrNull();

			if($handler === null)
				throw $e;
			else
				return $handler($e);
		}
	}
}
