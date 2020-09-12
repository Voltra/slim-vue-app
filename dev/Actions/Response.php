<?php

namespace App\Actions;


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
}
