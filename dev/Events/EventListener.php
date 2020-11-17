<?php


namespace App\Events;


interface EventListener
{
	/**
	 * Handle the event
	 * @psalm-template  T of Event
	 * @param T|object $event
	 * @return mixed
	 */
	public function handle(object $event);
}
