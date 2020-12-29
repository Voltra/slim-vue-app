<?php


namespace App\Exceptions;


use Throwable;

class RouteModelBindingFailure extends \Exception
{
	protected const DEFAULT_ERR_MSG = "Route model binding failed";

	public function __construct(string $message = self::DEFAULT_ERR_MSG, int $code = 0, Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}

	public static function of(string $name): RouteModelBindingFailure
	{
		return new static("Failed to resolve route model binding for route parameter: $name");
	}
}
