<?php


namespace App\Helpers;


abstract class AppEnv
{
	const PROD = "production";
	const DEV = "development";
	const TESTING = "test";

	public static function get(): string{
		return Env::get("PHP_ENV", static::PROD);
	}

	public static function dev(): bool{
		return static::get() === static::DEV;
	}

	public static function prod(): bool{
		return static::get() === static::PROD;
	}

	public static function testing(): bool{
		return static::get() === static::TESTING;
	}
}
