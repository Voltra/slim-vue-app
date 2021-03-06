<?php

namespace App\Helpers;


use App\Models\User;
use Slim\Psr7\Response;

class UserResponsePair
{
	/**
	 * @property-read Response $response
	 * @property-read User|null $user
	 */
	public $user, $response;

	public function __construct(Response $res, ?User $user = null)
	{
		$this->response = $res;
		$this->user = $user;
	}

	public function asArray(): array
	{
		return [$this->response, $this->user];
	}
}
