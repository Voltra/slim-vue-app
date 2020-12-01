<?php


namespace App\Handlers;


use Slim\Handlers\ErrorHandler;

class UniformErrorHandler
{
	/**
	 * @var array
	 */
	protected $handlers;

	public function __construct(array $handlers){
		$this->handlers = $handlers;
	}

	public function getHandler(string $class): ?callable{
		return $this->handlers[$class] ?? null;
	}
}
