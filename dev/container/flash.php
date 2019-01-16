<?php
use Slim\Container;
use Slim\Flash\Messages as FlashMessages;

return function(Container $c){
	return new FlashMessages();
};