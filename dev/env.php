<?php
use App\Helpers\Path;
use Dotenv\Dotenv;

$dotenv = new Dotenv(Path::root());
$dotenv->load();