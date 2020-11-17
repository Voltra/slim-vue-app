<?php

use App\Events\DemoEvent;
use App\Events\Events;
use Psr\Log\LoggerInterface;

Events::on(DemoEvent::class, static function(DemoEvent $event){
	$name = $event->getName();

	/**
	 * @var LoggerInterface $logger
	 */
	$logger = resolve(LoggerInterface::class);
	$logger->debug("Hello {$name}!");
});
