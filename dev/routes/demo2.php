<?php

use App\Helpers\Routing;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @var Slim\App $app
 */

$app->get("/user/{user_}", Routing::cm(\App\Controllers\DemoController::class, "user"));
