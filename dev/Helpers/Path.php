<?php
namespace App\Helpers;

define("ROOT", dirname(dirname(__DIR__)));
define("DEV", ROOT . "/dev");
define("PUBLIC_HTML", ROOT . "/public_html");
define("assets", PUBLIC_HTMl . "/assets");

abstract class Path{
	public static function root(string $path = ""){ return ROOT . $path; }
	public static function dev(string $path = ""){ return DEV . $path; }
	public static function public(string $path = ""){ return PUBLIC_HTML . $path; }
	public static function assets(string $path = ""){ return ASSETS . $path; }
}