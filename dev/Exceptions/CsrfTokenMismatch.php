<?php
namespace App\Exceptions;


use Throwable;

class CsrfTokenMismatch extends \Exception{
	const DEFAULT_ERR_MSG = "CSRF token mismatch";

	public function __construct(string $message = self::DEFAULT_ERR_MSG, int $code = 0, Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}