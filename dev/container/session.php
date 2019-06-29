<?php

use Slim\Container;
use SlimSession\Helper as Session;

return static function(Container $c){
	return new Session();
};