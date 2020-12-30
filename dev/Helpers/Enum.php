<?php


namespace App\Helpers;


use rikudou\PHPEnum\EnumTrait;

trait Enum
{
	use EnumTrait;

	/**
	 * The list of allowed values
	 * @see https://packagist.org/packages/rikudou/enums-trait
	 * @return array
	 */
	protected abstract static function allowedValues(): array;
}
