<?php

namespace App\Config;

use Illuminate\Support\Env;
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
			"2fa" => [
				"issuer" => "",
				"algo" => "sha1",
				"digits" => 6,
				"period" => 30,
				"qr_provider" => \RobThree\Auth\Providers\Qr\ImageChartsQRCodeProvider::class,
				"label_field" => "email",
			],
			"mail" => [
				"type" => "smtp",
				"host" => "",
				"port" => "25",
				"username" => Env::get("MAIL_USERNAME", ""),
				"password" => Env::get("MAIL_PASSWORD", ""),
				"mjml_exe" => "mjml",
				"from" => [
					"addr" => "",
					"name" => "",
				],
				"reply_to" => [
					"addr" => "",
					"name" => "",
				],
			],
			"errors" => [
				"delegate" => false,
			],
		];
	}
}
