<?php
require_once "../vendor/autoload.php";
require_once "env.php";

$container = require("container.php");
$config = $container->get("config");
$settings = $container->get("settings");
$db = (require_once("db.php"))($config);

$app = \DI\Bridge\Slim\Bridge::create($container);
$container->set(\Slim\App::class, $app);

(require_once("middlewares.php"))($app, $container, $config, $settings);

require_once "route_autoload.php";

return $app;
