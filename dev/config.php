<?php

use App\Config\Config;
use App\Helpers\Path;
use Illuminate\Support\Env;

$configMode = Env::get("PHP_ENV", "production");
return Config::load(Path::dev("/Config/{$configMode}.php"));
