<?php

use App\Controllers\DemoController;
use App\Filters\VisitorFilter;
use App\Helpers\Routing;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use function App\Filters\composeFilters;

/**
 * @var Slim\App $app
 */

$app->get("/", cm(DemoController::class, "home"))
/*->add(composeFilters([
	VisitorFilter::class,
	VisitorFilter::class,
]))*/->setName("home");
