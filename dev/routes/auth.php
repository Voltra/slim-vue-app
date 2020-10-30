<?php

/**
 * @var \Slim\App $app
 */

use App\Actions\Auth;
use App\Controllers\AuthController;
use App\Filters\LogoutFilter;
use App\Filters\UserFilter;
use App\Filters\VisitorFilter;
use App\Models\User;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
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

$app->get("/auth/force-login/{__user}", function(ServerRequestInterface $req,  Response $res, User $user){
	/**
	 * @var Auth $auth
	 */
	$auth = resolve(Auth::class);

	/**
	 * @var \App\Actions\Response $responseUtils
	 */
	$responseUtils = resolve(\App\Actions\Response::class);

	$response = $auth->forceLogin($res, $user->username)->response;
	return $responseUtils->redirectToRoute($response, "home");
})->setName("auth.force_login")
->add($forVisitor);
