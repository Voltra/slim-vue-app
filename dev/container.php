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
 * @param string $key
 * @return mixed
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function resolve(string $key){
	global $container;
	return $container->get($key);
}

return $container;
