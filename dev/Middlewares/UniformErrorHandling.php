<?php


namespace App\Middlewares;


use App\Handlers\UniformErrorHandler;
use LazyCollection\Stream;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class UniformErrorHandling extends Middleware
{
	/**
	 * @var UniformErrorHandler
	 */
	protected $eh;

	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
		$this->eh = $this->container->get(UniformErrorHandler::class);
	}

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
			$handler = Stream::fromIterable([$class], false)
				->then(class_parents($class))
				->then(class_implements($class))
				->unique()
				->map([$this->eh, "getHandler"])
				->firstOrNull();

			if($handler === null)
				throw $e;
			else
				return $handler($e, $req);
		}
	}
}
