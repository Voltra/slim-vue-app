<?php

/**
 * @var \Slim\App $app
 */

use App\Controllers\AuthController;
use App\Filters\UserFilter;
use App\Filters\VisitorFilter;
use Slim\Routing\RouteCollectorProxy;
use function App\Filters\filter;

//TODO: Better grouping "Cannot register two routes matching /auth for method GET"

$app->group("/auth", function (RouteCollectorProxy $group){ // [auth]
	$group->get("", function(RouteCollectorProxy $group){ // [auth]:visitor
		$group->get("/login", cm(
			AuthController::class,
			"loginForm"
		))->setName("auth.login");

		$group->get("/register", cm(
			AuthController::class,
			"registerForm"
		))->setName("auth.register");

		$group->post("/login", cm(
			AuthController::class,
			"login"
		))->setName("auth.login.post");

		$group->post("/register", cm(
			AuthController::class,
			"register"
		))->setName("auth.register.post");
	})->add(filter(VisitorFilter::class)); // [/auth]:visitor

	$group->get("", function(RouteCollectorProxy $group){ // [auth]:user
		$group->get("/logout", cm(
			AuthController::class,
			"logout"
		))->setName("auth.logout");
	})->add(filter(UserFilter::class)); // [/auth]:user
}); // [/auth]
