<?php

use App\Helpers\Path;
use Monolog\Logger;

return [
	"debug" => true,
	"settings" => [
		"name" => "slim_vue_app",
		"debug" => true,
		"displayErrorDetails" => true,
		"logErrors" => true,
		"logErrorDetails" => true,
	],
	"logs" => [
		"name" => "slim",
		"path" => "/logs/slim.log", // relative to the project root path
		"level" => Logger::DEBUG,
	],
	"views" => [
		"cache" => false,
		"debug" => true,
	],
	"csrf" => [
		"key" => "csrf_token",
	],
	"random" => [
		"length" => 128,
		"alphabet" => null,
	],
	"session" => [
		"name" => "session",
		"autorefresh" => true,
		"lifetime" => "2 hours",
		"samesite" => true,
		"httponly" => true,
	],
	"hash" => [
		"algo" => PASSWORD_BCRYPT,
		"cost" => 12,
		"alt_algo" => "sha256",
	],
	"auth" => [
		"container" => "user",
		"session" => "user_id",
		"remember_name" => "user_remember",
		"remember_exp" => "+2 week",
		"cookie_separator" => "____",
	],
	"db" => [
		"driver" => "mysql",
		"host" => "localhost",
		"port" => "3306",
		"database" => "slim_vue_app",
		"username" => "root",
		"password" => "",
		"charset" => "utf8",
		"collation" => "utf8_unicode_ci",
		"prefix" => "",
	],
	"viewModelBinding" => [
		"__user" => [
			"model" => \App\Models\User::class,
			"column" => "username",
		],
	],
	"redirect" => [
		"mode" => "qs",
		"key" => "redir",
		"attribute" => "shouldRedirect",
	],
	"2fa" => [
		"issuer" => "slim-vue-app.ninja",
		"algo" => "sha1",
		"digits" => 6,
		"period" => 30,
		"qr_provider" => \RobThree\Auth\Providers\Qr\ImageChartsQRCodeProvider::class,
		"label_field" => "username",
	],
];
