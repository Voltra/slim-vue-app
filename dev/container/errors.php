<?php

use App\Exceptions\InvalidFormRequest;
use App\Exceptions\RouteModelBindingFailure;
use App\Handlers\UniformErrorHandler;
use DI\Container;
use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;
use SlimSession\Helper as Session;

function doThrow(string $class): callable{
	return function(Throwable $e, Request $req) use ($class): Response {
		throw new $class();
	};
}

return static function(Container $container){
	$throwInternalServerError = doThrow(HttpInternalServerErrorException::class);
	$throwNotFound = doThrow(HttpNotFoundException::class);

	return new UniformErrorHandler([
		NotFoundExceptionInterface::class => $throwInternalServerError,
		ContainerExceptionInterface::class => $throwInternalServerError,
		RouteModelBindingFailure::class => $throwNotFound,
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
