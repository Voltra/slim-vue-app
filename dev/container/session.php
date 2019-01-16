<?php

use Slim\Container;
use SlimSession\Helper as Session;

return function(Container $c){
	return new Session();
};