<?php

namespace App\Actions;


use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Headers;
use Slim\Psr7\Response as SlimResponse;

class Response extends Action
{
	public function upgrade(ResponseInterface $res): SlimResponse
	{
		$headers = new Headers($res->getHeaders());
		return new SlimResponse($res->getStatusCode(), $headers, $res->getBody());
	}

	public function redirect(ResponseInterface $res, string $location, int $status = Httpstatuscodes::HTTP_TEMPORARY_REDIRECT): ResponseInterface{
		return $res->withStatus($status)->withHeader("Location", $location);
	}

	public function withJSON(ResponseInterface $res, $data): ResponseInterface{
		$json = json_encode($data);
		$res->getBody()->write($json);
		return $res->withHeader("Content-Type", "application/json");
	}
}
