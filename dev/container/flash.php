<?php
use Slim\Container;
use Slim\Flash\Messages as FlashMessages;

return static function(Container $c){
	return new FlashMessages();
};