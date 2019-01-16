<?php

use App\Actions\Auth;
use App\Actions\Cookies;
use App\Actions\Csrf;
use App\Actions\Flash;
use App\Actions\Hash;
use App\Actions\PostValidator;
use App\Actions\Random;
use App\Actions\Response;
use Slim\Container;

function registerAction(string $class){
	return function(Container $c) use($class){
		return new $class($c);
	};
}

return array_reduce(array_map(function($class){
	return [$class => registerAction($class)];
}, [
	PostValidator::class,
	Response::class,
	Hash::class,
	Random::class,
	Flash::class,
	Cookies::class,
	Csrf::class,
	Auth::class,
]), "array_merge", []);