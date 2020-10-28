<?php

/**
 * @var \Slim\App $app
 */

use App\Controllers\DemoController;
use App\Controllers\TwoFactorController;
use App\Filters\UserFilter;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use function App\Filters\filter;

$app->get("/2fa/{__user}", cm(TwoFactorController::class, "twoFactor"))
	->add(filter(UserFilter::class))
	->setName("demo.2fa");

$app->get("/2fa/enable/{__user}", cm(TwoFactorController::class, "enable2FA"))
	->add(filter(UserFilter::class))
	->setName("demo.2fa.enable");

$app->get("/2fa/disable/{__user}", cm(TwoFactorController::class, "disable2FA"))
	->add(filter(UserFilter::class))
	->setName("demo.2fa.disable");
