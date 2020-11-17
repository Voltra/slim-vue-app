<?php
require_once "../vendor/autoload.php";
require_once "env.php";

$container = require_once("container.php");
$config = $container->get("config");
$settings = $container->get("settings");
$setupDb = require_once("db.php");
$db = $setupDb($config);

$app = \DI\Bridge\Slim\Bridge::create($container);
$container->set(\Slim\App::class, $app);

require("listeners.php");

$applyMiddlewares = require_once("middlewares.php");
$applyMiddlewares($app, $container, $config, $settings);

require_once "route_autoload.php";

return $app;
