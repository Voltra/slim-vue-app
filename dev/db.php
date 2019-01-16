<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$db = new Capsule();
$db->addConnection($config["db"]);
$db->setAsGlobal();
$db->bootEloquent();

return $db;