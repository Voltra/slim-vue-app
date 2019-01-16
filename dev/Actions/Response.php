<?php
namespace App\Actions;


use Psr\Http\Message\ResponseInterface;
use Slim\Http\Headers;
use Slim\Http\Response as SlimResponse;

class Response extends Action{
	public function upgrade(ResponseInterface $res): SlimResponse{
		$headers = new Headers();
		foreach($res->getHeaders() as $key => $values)
			$headers->add($key, $values);

		return new SlimResponse($res->getStatusCode(), $headers, $res->getBody());
	}
}