<?php

use App\Helpers\Path;
use DI\ContainerBuilder;

$config = require_once("config.php");

$builder = new ContainerBuilder();
$builder->useAutowiring(true)
	->useAnnotations(true)
	->addDefinitions(Path::dev("/container/definitions.php"));

$container = $builder->build();

/**
 * Resolve a dependency using the DI container
 * @template T
 * @param class-string<T>|string|mixed $key
 * @return T|mixed
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function resolve($key){
	global $container;
	return is_string($key) ? $container->get($key) : $key;
}

function controllerMethod(string $controllerClass, string $method): string
{
	return \App\Helpers\Routing::controllerMethod($controllerClass, $method);
}

function cm(string $controllerClass, string $method): string
{
	return controllerMethod($controllerClass, $method);
}

return $container;
