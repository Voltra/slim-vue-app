<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class RequestBinding extends Middleware
{

	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		$this->container->set("request", $req);
		$this->container->set(ServerRequestInterface::class, $req);
		$res = $handler->handle($req);
		return $this->responseUtils->upgrade($res);
	}
}
