<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/", function(Request $rq, Response $response){
    return $this->view->render($response, "demo.twig", [
        "phpver" => phpversion()
    ]);
});