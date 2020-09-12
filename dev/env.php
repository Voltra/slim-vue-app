<?php

use App\Helpers\Path;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Path::root());
$env = $dotenv->load();
