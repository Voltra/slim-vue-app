<?php

use App\Exceptions\Invalid2FA;
use App\Handlers\UniformErrorHandler;
use DI\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Response;

function doThrow(string $class = HttpInternalServerErrorException::class): callable{
	return function(Throwable $e, Request $req) use ($class) {
		throw new $class();
	};
}

return static function(Container $container){
	return new UniformErrorHandler([
		NotFoundExceptionInterface::class => doThrow(HttpInternalServerErrorException::class),
		ContainerExceptionInterface::class => doThrow(HttpInternalServerErrorException::class),
	]);
};
