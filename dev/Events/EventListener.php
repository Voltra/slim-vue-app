<?php


namespace App\Events;


interface EventListener
{
	/**
	 * Handle the event
	 * @param Event $event
	 * @return mixed
	 */
	public function handle(/*Event*/ $event);
}
