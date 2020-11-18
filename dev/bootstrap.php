<?php
//for emails: https://odan.github.io/2020/04/11/slim4-sending-emails.html
// https://packagist.org/packages/qferr/mjml-twig

require_once "../vendor/autoload.php";
require_once "env.php";

$container = require_once("container.php");
require_once "events.php"; // register events' listeners
$config = $container->get("config");
$settings = $container->get("settings");

$setupDb = require_once("db.php");
$db = $setupDb($config);

$app = \DI\Bridge\Slim\Bridge::create($container);
$container->set(\Slim\App::class, $app);

$applyMiddlewares = require_once("middlewares.php");
$applyMiddlewares($app, $container, $config, $settings); // apply the middlewares to the app

require_once "route_autoload.php";

return $app;
