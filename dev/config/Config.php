<?php
namespace App\Config;

use Noodlehaus\Config as HassankhanConfig;

class Config extends HassankhanConfig{
	protected function getDefaults() {
		return [
			"debug" => false,
			"settings" => [
				"name" => "",
				"debug" => false,
				"displayErrorDetails" => false
			],
			"views" => [],
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
				"lifetime" => "20 minutes"
			],
			"hash" => [
				"algo" => PASSWORD_BCRYPT,
				"cost" => PASSWORD_BCRYPT_DEFAULT_COST,
				"alt_algo" => "sha256"
			],
			"auth" => [
				"container" => "user",
				"session" => "auth",
				"remember_name" => "remember",
				"remember_exp" => "+2 week",
				"cookie_separator" => "<@>"
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
			]
		];
	}
}