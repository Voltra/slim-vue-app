<?php


namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class BackUrl extends Middleware
{

    public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
    {
    	$res = $handler->handle($req);
    	$url = $req->getUri()->getPath();
    	$this->session->set("last_url", $url);
    	return $res;
    }
}
