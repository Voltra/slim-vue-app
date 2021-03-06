<?php

namespace App\Actions;


use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Headers;
use Slim\Psr7\Response as SlimResponse;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;

class Response extends Action
{
	public function upgrade(ResponseInterface $res): SlimResponse
	{
		$headers = new Headers($res->getHeaders());
		return new SlimResponse($res->getStatusCode(), $headers, $res->getBody());
	}

	public function redirect(ResponseInterface $res, string $location): ResponseInterface{
		return $res->withHeader("Location", $location);
	}

	public function redirectWith(ResponseInterface $res, string $location, int $status = Httpstatuscodes::HTTP_TEMPORARY_REDIRECT){
		return $this->redirect($res->withStatus($status), $location);
	}

	public function redirectToRoute(ResponseInterface $res, string $route, array $params = [], array $qs = []){
		$parser = $this->container->get(RouteParser::class);
		$url = $parser->urlFor($route, $params, $qs);
		return $this->redirect($res, $url);
	}

	public function withJSON(ResponseInterface $res, $data): ResponseInterface{
		$json = json_encode($data);
		$res->getBody()->write($json);
		return $res->withHeader("Content-Type", "application/json");
	}
}
