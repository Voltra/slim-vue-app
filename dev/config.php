<?php
use App\Config\Config;
use App\Helpers\Path;

$configMode = $_ENV["NODE_ENV"];
return Config::load(Path::dev("/Config/{$configMode}.php"));