<?php

use App\Events\Database\AfterBoot;
use App\Events\Database\BeforeBoot;
use Illuminate\Database\Capsule\Manager as Capsule;

return static function ($config) {
	$db = new Capsule();
	$db->addConnection($config["db"]);
	$db->setAsGlobal();

	BeforeBoot::dispatch($db);
	$db->bootEloquent();
	AfterBoot::dispatch($db);

	return $db;
};
