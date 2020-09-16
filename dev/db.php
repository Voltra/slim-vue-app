<?php

use Illuminate\Database\Capsule\Manager as Capsule;

return static function ($config) {
	$db = new Capsule();
	$db->addConnection($config["db"]);
	$db->setAsGlobal();
	$db->bootEloquent();

	return $db;
};
