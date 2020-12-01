<?php

use App\Exceptions\Invalid2FA;
use App\Handlers\UniformErrorHandler;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

return static function(Container $container){
	return new UniformErrorHandler([
		Invalid2FA::class => static function(Invalid2FA $error, ServerRequestInterface $req): ResponseInterface{
			$res = new Response(random_int(200, 500));
			$res->getBody()->write($error->getTraceAsString());
			return $res;
		},
	]);
};
