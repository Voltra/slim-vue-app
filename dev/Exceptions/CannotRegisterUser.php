<?php


namespace App\Exceptions;


use Throwable;

class CannotRegisterUser extends \Exception
{
	protected const DEFAULT_ERR_MSG = "Username already taken";

	public function __construct(string $message = self::DEFAULT_ERR_MSG, int $code = 0, Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
