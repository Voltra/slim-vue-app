<?php

use App\Helpers\Path;
use Dotenv\Dotenv;
use Illuminate\Support\Env;

$dotenv = Dotenv::createImmutable(Path::root());
$env = $dotenv->load();
