<?php

use App\Controllers\DemoController;
use App\Mails\Mail;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use Symfony\Component\Mime\Address;

/**
 * @var Slim\App $app
 */

$app->get("/", cm(DemoController::class, "home"))
->setName("home");

$app->get("/mail", function(Request $req,  Response $res, \App\Actions\Response $responseUtils){
	Mail::create()
	->subject("Demo mail")
	->to(new Address("test@test.test", "Test Dude"))
	->template("demo.mjml.twig")
	->send();

	return $responseUtils->redirectToRoute($res, "home");
})->setName("mails.test");
