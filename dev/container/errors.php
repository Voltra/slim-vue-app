<?php

use App\Exceptions\InvalidFormRequest;
use App\Handlers\UniformErrorHandler;
use DI\Container;
use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Response;
use SlimSession\Helper as Session;

function doThrow(string $class = HttpInternalServerErrorException::class): callable{
	return function(Throwable $e, Request $req) use ($class): Response {
		throw new $class();
	};
}

return static function(Container $container){
	return new UniformErrorHandler([
		NotFoundExceptionInterface::class => doThrow(HttpInternalServerErrorException::class),
		ContainerExceptionInterface::class => doThrow(HttpInternalServerErrorException::class),
		InvalidFormRequest::class => static function(InvalidFormRequest $e, Request $req){
			$errors = $e->getErrors();

			/**
			 * @var Session $session
			 */
			$session = resolve(Session::class);
			$session->set("errors", $errors);

			/**
			 * @var \App\Actions\Response $responseUtils
			 */
			$responseUtils = resolve(\App\Actions\Response::class);

			$r = new Response();
			return $responseUtils->redirectBack($r, Httpstatuscodes::HTTP_BAD_REQUEST);
		},
	]);
};
