<?php
return [
	"debug" => true,
	"settings" => [
		"name" => "mvea",
		"debug" => true,
		"displayErrorDetails" => true
	],
	"views" => [],
	"csrf" => [
		"key" => "csrf_token"
	],
	"random" => [
		"length" => 128,
		"alphabet" => null
	],
	"session" => [
		"name" => "session",
		"autorefresh" => true,
		"lifetime" => "2 hours"
	],
	"hash" => [
		"algo" => PASSWORD_BCRYPT,
		"cost" => 12,
		"alt_algo" => "sha256"
	],
	"auth" => [
		"container" => "user",
		"session" => "user_id",
		"remember_name" => "user_remember",
		"remember_exp" => "+2 week",
		"cookie_separator" => "____"
	],
	"db" => [
		"driver" => "mysql",
		"host" => "localhost",
		"port" => "3308",
		"database" => "mvea",
		"username" => "root",
		"password" => "",
		"charset" => "utf8",
		"collation" => "utf8_unicode_ci",
		"prefix" => "",
	]
];