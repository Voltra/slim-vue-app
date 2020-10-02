<?php

/**
 * @var \Slim\App $app
 */

use App\Controllers\AuthController;
use App\Filters\LogoutFilter;
use App\Filters\UserFilter;
use App\Filters\VisitorFilter;
use function App\Filters\filter;

$forVisitor = filter(VisitorFilter::class);
$forUser = filter(UserFilter::class);
$forLogout = filter(LogoutFilter::class);

$app->get("/auth/login", cm(
	AuthController::class,
	"loginForm"
))->setName("auth.login")
->add($forVisitor);

$app->get("/auth/register", cm(
	AuthController::class,
	"registerForm"
))->setName("auth.register")
->add($forVisitor);

$app->post("/auth/login", cm(
	AuthController::class,
	"login"
))->setName("auth.login.post")
->add($forVisitor);

$app->post("/auth/register", cm(
	AuthController::class,
	"register"
))->setName("auth.register.post")
->add($forVisitor);

$app->get("/auth/logout", cm(
	AuthController::class,
	"logout"
))->setName("auth.logout")
->add($forLogout);
