<?php

use App\Helpers\Routing;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @var Slim\App $app
 */

$app->get("/", Routing::cm(\App\Controllers\DemoController::class, "home"));
