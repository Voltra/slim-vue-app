<?php

use Middlewares\TrailingSlash;
use Slim\Middleware\ContentLengthMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Middleware\Session;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;
use Slim\Views\TwigMiddleware;

return static function(\Slim\App $app, \DI\Container $container, $config, $settings){
	$errorMiddleware = $app->addErrorMiddleware(
		$settings["displayErrorDetails"],
		$settings["logErrors"],
		$settings["logErrorDetails"],
		$container->get("logger")
	);
	//TODO: Add custom error handlers

	$app->addRoutingMiddleware();
	$app->addBodyParsingMiddleware();


	$app->add(new TrailingSlash(false)) // Force remove trailing slash
	->add(new MethodOverrideMiddleware()) // Allow method override in forms
	->add(new ContentLengthMiddleware()) // Add correct content length
	->add(new WhoopsMiddleware())
	->add(new Session($config["session"]))
	->add(TwigMiddleware::createFromContainer($app))
	->add(App\Middlewares\RequestBinding::from($container)) // Add request to the container
	->add(App\Middlewares\Csrf::from($container))
	->add(App\Middlewares\Auth::from($container));
};
