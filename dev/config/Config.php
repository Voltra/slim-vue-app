<?php

namespace App\Config;

use Noodlehaus\Config as HassankhanConfig;
use Monolog\Logger;

class Config extends HassankhanConfig
{
	protected function getDefaults()
	{
		return [
			"debug" => false,
			"settings" => [
				"name" => "",
				"debug" => false,
				"displayErrorDetails" => false,
				"logErrors" => true,
				"logErrorDetails" => false,
			],
			"logs" => [
				"name" => "slim",
				"path" => "/logs/slim.log", // relative to the project root path
				"level" => Logger::ERROR,
			],
			"views" => [
				"cache" => sys_get_temp_dir() . "/views", // OR Path::cache("views")
			],
			"csrf" => [
				"key" => "csrf_token"
			],
			"random" => [
				"length" => 60,
				"alphabet" => null
			],
			"session" => [
				"name" => "session",
				"autorefresh" => true,
				"lifetime" => "20 minutes",
				"samesite" => true,
				"httponly" => true,
			],
			"hash" => [
				"algo" => PASSWORD_BCRYPT,
				"cost" => PASSWORD_BCRYPT_DEFAULT_COST,
				"alt_algo" => "sha256",
			],
			"auth" => [
				"container" => "user",
				"session" => "auth",
				"remember_name" => "remember",
				"remember_exp" => "+2 week",
				"cookie_separator" => "<@>",
			],
			"db" => [
				"driver" => "mysql",
				"host" => "localhost",
				"port" => "3306",
				"database" => "",
				"username" => "",
				"password" => "",
				"charset" => "",
				"collation" => "",
				"prefix" => "",
			],
			"viewModelBinding" => [],
			"redirect" => [
				"mode" => "qs",
				"key" => "redir",
				"attribute" => "shouldRedirect",
			],
		];
	}
}
