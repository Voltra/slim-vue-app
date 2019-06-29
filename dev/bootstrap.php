<?php
require_once "../vendor/autoload.php";

use App\Helpers\Path;
use Slim\App as SlimApp;
use Slim\Middleware\Session as SlimSession;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;


require_once "env.php";
$config = require_once("config.php");
$db = require_once("db.php");

$app = new SlimApp([
	"config" => $config,
	"settings" => $config["settings"]
]);
$container = $app->getContainer();

session_start();
foreach(require_once(Path::dev("/container/actions.php")) as $class => $factory)
	$container[$class] = $factory;

foreach(["session", "flash", "view"] as $item)
	$container[$item] = require_once(Path::dev("/container/{$item}.php"));

$app->add(new WhoopsMiddleware($app))
	->add(new SlimSession($config["session"]))
	->add(App\Middlewares\Csrf::from($container))
	->add(App\Middlewares\Auth::from($container));

require_once "route_autoload.php";

return $app;