<?php

use App\Helpers\Path;
use DI\ContainerBuilder;

$config = require_once("config.php");

$builder = new ContainerBuilder();
$builder->useAutowiring(true)
	->useAnnotations(true)
	->addDefinitions(Path::dev("/container/definitions.php"));

$container = $builder->build();

return $container;
