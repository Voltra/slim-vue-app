<?php


namespace App\Helpers;


abstract class Routing
{
	public static function controllerMethod(string $controllerClass, string $method){
		return "$controllerClass::$method";
	}

	public static function cm(string $controllerClass, string $method){
		return self::controllerMethod($controllerClass, $method);
	}
}
