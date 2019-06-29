<?php

use App\Helpers\Path;
use App\Helpers\TwigExtensions\CsrfExtension;
use App\Helpers\TwigExtensions\PathExtension;
use Knlv\Slim\Views\TwigMessages as TwigFlash;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension as BaseTwigTools;

return static function(Container $c){
	$config = $c["config"];
	$view = new Twig(Path::dev("/views"), $config["views"]);
	$router = $c->router;
	$uri = Uri::createFromEnvironment(new Environment($_SERVER));

	$view->addExtension(new BaseTwigTools($router, $uri));
	$view->addExtension(new TwigFlash($c->flash));
	$view->addExtension(new CsrfExtension($c));
	$view->addExtension(new PathExtension());
	return $view;
};