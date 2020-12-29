---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 11
title: Events
---

In an order to separate logic, an event system has been introduced that allows for more decoupling and reusability.
Events are located in the `App\Events` namespace and must extend `App\Events\Event`.
It is a wrapper around [illuminate/events](https://packagist.org/packages/illuminate/events).

The `App\Events\Events` utility class allow triggering events and listening for events. Events can be dispatched with
additional arguments: `Events::trigger($event, $payload = [])`:
```php
abstract class Events{
	/**
	 * Trigger the given event with the given payload
	 * @param Event $event
	 * @param array $payload
	 */
	public static function trigger(Event $event, $payload = []){}

	/**
	 * Trigger the given event with the given payload if the given condition is true
 	 * @param bool $condition
	 * @param Event $event
	 * @param array $payload
	 */
	public static function triggerIf(bool $condition, Event $event, $payload = []){}

	/**
	 * Listen to the given events
	 * @param Closure|array|string $events
	 * @param Closure|string|null $listener
	 */
	public static function on($events, $listener = null){}
}
```

You can either user closures as listeners or a specific class that implements `App\Events\EventListener`.
You can also use method references.

Event listeners are registered in `dev/events.php`:
```php
class MyListener{
	public function myMethod(UserCreated $event){}
}

Events::on(UserCreated::class, [MyListener::class, "myMethod"]);
```

These are the predefined events:
* `App\Events\Database\AfterBoot` that is emitted after Eloquent has been booted
* `App\Events\Database\BeforeBoot` that is emitted before Eloquent boots
* `App\Events\Database\DatabaseEvent` an abstract base class for database events
* `App\Events\User\UserCreated` that is emitted once a user has been created
* `App\Events\User\UserEvent` an abstract base class for user events
* `App\Events\User\UserLoggedIn` that is emitted once a user logs in
* `App\Events\User\UserLoggedOut` that is emitted once a user logs out

`App\Events\User\UserLogListener` is a demo event listener that just logs out information about each user event.
