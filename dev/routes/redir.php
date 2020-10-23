<?php

/**
 * @var \Slim\App $app
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get("/redirectable", function(ServerRequestInterface $req, \Slim\Psr7\Response $res){
	return $res;
})->add(\App\Middlewares\AcceptsRedirect::from($app->getContainer()))
->setName("redirectable");
