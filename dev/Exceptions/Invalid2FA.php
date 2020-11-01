<?php


namespace App\Exceptions;


use Throwable;

class Invalid2FA extends \Exception
{
	protected const DEFAULT_ERR_MSG = "Invalid 2FA code";

	public function __construct(string $message = self::DEFAULT_ERR_MSG, int $code = 0, Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
