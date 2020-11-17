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
	 * @return Event
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public static function trigger(Event $event, $payload = []){
		/**
		 * @var Dispatcher $dispatcher
		 */
		$dispatcher = resolve(Dispatcher::class);
		$dispatcher->dispatch($event, $payload,false);
		return $event;
	}

	/**
	 * Trigger the event only if the given condition is true
	 * @param bool $condition - The condition to trigger the event
	 * @param Event $event - The event to trigger
	 * @param array $payload - The additional payload of data
	 * @return Event
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public static function triggerIf(bool $condition, Event $event, $payload = []){
		if($condition)
			static::trigger($event, $payload);

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
