<?php

use App\Helpers\Twig\CsrfExtension;
use App\Helpers\Twig\PathExtension;
use App\Path;
use Knlv\Slim\Views\TwigMessages as TwigFlash;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension as BaseTwigTools;

return function(Container $c){
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