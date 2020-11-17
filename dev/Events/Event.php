<?php


namespace App\Events;


abstract class Event
{
	public function __construct(...$args){}

	/**
	 * Construct and dispatch an event
	 * @param mixed ...$args - The constructor's arguments
	 * @return Event
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public static function dispatch(...$args){
		return Events::trigger(new static(...$args));
	}
}
