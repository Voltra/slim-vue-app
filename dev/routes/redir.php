<?php

/**
 * @var \Slim\App $app
 */

use App\Middlewares\AcceptsRedirect;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get("/redirectable", function(ServerRequestInterface $req, \Slim\Psr7\Response $res){
	return $res;
})->add(AcceptsRedirect::from($app->getContainer()))
->setName("redirectable");
