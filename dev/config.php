<?php

use App\Config\Config;
use App\Helpers\Path;
use Illuminate\Support\Env;

$configMode = \App\Helpers\AppEnv::get();
return Config::load(Path::dev("/Config/{$configMode}.php"));
