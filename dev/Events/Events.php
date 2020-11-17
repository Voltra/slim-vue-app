<?php


namespace App\Events;


use Closure;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Events\Dispatcher;

abstract class Events
{
	/**
	 * Trigger an event
	 * @param Event $event - The event to trigger
	 * @param array $payload - The optional payload of data to pass along
	 * @param bool $halt - Whether or not to halt
	 * @return Event
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public static function trigger(Event $event, $payload = [], bool $halt = false){
		/**
		 * @var Dispatcher $dispatcher
		 */
		$dispatcher = resolve(Dispatcher::class);
		$dispatcher->dispatch($event, $payload, $halt);
		return $event;
	}

	/**
	 * Listen to an event
	 * @param Closure|array|string $events - The event(s) to listen to
	 * @param Closure|string|null $listener - The event listener
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public static function on($events, $listener = null){
		/**
		 * @var Dispatcher $dispatcher
		 */
		$dispatcher = resolve(Dispatcher::class);
		$dispatcher->listen($events, $listener);
	}
}
