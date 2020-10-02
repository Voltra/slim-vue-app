<?php

use Middlewares\TrailingSlash;
use Slim\Middleware\ContentLengthMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Middleware\Session;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface as Logger;
use Slim\Psr7\Response;

function handleError($app){
	return function(Request $request, Throwable $throwable, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails, ?Logger $logger = null) use($app){
		$container = $app->getContainer();
		$response = new Response();
		//TODO: Custom error handling
		//TODO: Custom rendering for deifferent status

		$status = 404;
		return $container->view->render($response->withStatus($status), "errors/$status.twig", []);
	};
}

return static function(\Slim\App $app, \DI\Container $container, $config, $settings){
	$displayErrorDetails = $settings["displayErrorDetails"];
	$logErrors = $settings["logErrors"];
	$logErrorDetails = $settings["logErrorDetails"];
	$logger = $container->get("logger");

	$app->add(\App\Middlewares\RouteModelBinding::from($container)); //WARNING: Experimental due to Slim4's new way of handling request parameters...
	$app->addRoutingMiddleware();
	$app->addBodyParsingMiddleware();

	$app->add(new TrailingSlash(false)) // Force remove trailing slash
	->add(new MethodOverrideMiddleware()) // Allow method override in forms
	->add(new ContentLengthMiddleware()) // Add correct content length
	->add(new Session($config["session"]))
	->add(TwigMiddleware::createFromContainer($app))
	->add(\App\Middlewares\Csrf::from($container))
	->add(\App\Middlewares\Auth::from($container))
	->add(\App\Middlewares\RequestBinding::from($container)) // Add request to the container
	->add(new WhoopsMiddleware());

	$eh = new \App\Handlers\ExceptionHandler($app->getCallableResolver(), $app->getResponseFactory());
	$request = \Slim\Factory\ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();
	$lh = new \App\Handlers\LegacyPhpErrorHandler($request, $eh, $displayErrorDetails, $logErrors, $logErrorDetails);
	register_shutdown_function($lh);

	$app->addErrorMiddleware(
		$displayErrorDetails,
		$logErrors,
		$logErrorDetails,
		$logger
	)->setDefaultErrorHandler($eh);
};
