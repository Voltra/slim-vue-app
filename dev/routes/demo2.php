<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/user/{user}", function(Request $rq, Response $response, array $args){
    return $this->view->render($response, "demo2.twig", [
        "user" => $args["user"]
    ]);
});