<?php
use App\Path;
use Dotenv\Dotenv;

$dotenv = new Dotenv(Path::root());
$dotenv->load();