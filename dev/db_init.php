<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$dbconfig = $app->getContainer()["config"]->get("db");


//add the connection
$capsule->addConnection([
    "driver" => $dbconfig["driver"],
    "host" => $dbconfig["host"],
    "database" => $dbconfig["database"],
    "username" => $dbconfig["username"],
    "password" => $dbconfig["password"],
    "charset" => $dbconfig["charset"],
    "collation" => $dbconfig["collation"],
    "prefix" => $dbconfig["prefix"]
]);

//boot Eloquent
$capsule->bootEloquent();

return $capsule;