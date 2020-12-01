<?php


namespace App\Actions;


use Psr\Http\Message\ServerRequestInterface;
use Rakit\Validation\Validation;

class Validator extends Action
{
	public function dataFrom(ServerRequestInterface $req): array{
		return array_merge(
			$req->getQueryParams(),
			$req->getParsedBody(),
			$req->getUploadedFiles()
		);
	}

	public function make(ServerRequestInterface $req, array $rules = [], array $messages = []): Validation
	{
		$data = $this->dataFrom($req);
		return $this->makeValidation($data, $rules, $messages);
	}

	public function makeValidation(array $data = [], array $rules = [], array $messages = []): Validation{

		$validator = new \Rakit\Validation\Validator($messages);
		return $validator->make($data, $rules, $messages);
	}
}
