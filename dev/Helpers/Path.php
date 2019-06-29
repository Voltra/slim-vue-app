<?php
namespace App\Helpers;

define("ROOT", dirname(__DIR__, 2));
define("DEV", ROOT . "/dev");
define("PUBLIC_HTML", ROOT . "/public_html");
define("ASSETS", PUBLIC_HTML . "/assets");

abstract class Path{
	public static function root(string $path = ""): string { return ROOT . $path; }
	public static function dev(string $path = ""): string { return DEV . $path; }
	public static function public(string $path = ""): string { return PUBLIC_HTML . $path; }
	public static function assets(string $path = ""): string { return ASSETS . $path; }
}