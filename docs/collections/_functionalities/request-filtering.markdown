---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 7
title: Request filtering
---

In the namespace `App\Filters` you will find several filter classes that all extend from `App\Filters\Filter`.
These are authorization driven simple middlewares designed to "guard" routes from unauthorized users.

Symptomatic use cases may be:
* Allowing access to some resources only to connected users
* Allow editing only to the author of a post
* Allowing access only to admins

This is the basic API:
```php
abstract class Filter extends Middleware{
	/**@var RouteParserInterface $router*/
	protected $router;

	/**@var App\Actions\Auth $auth*/
	protected $auth;

	/**
 	 * Determine whether or not the current user can use this route
	 * @return bool
	 */
	protected abstract function isAuthorized(): bool;

	/**
 	 * The redirect status to use (`null` will use the default status from Slim), for convenience you may use lukasoppermann/http-status
	 * @return int|null
	 */
	protected abstract function redirectStatus(): ?int;

	/**
 	 * The URL to redirect to if the user is not authorized
	 * @return string
	 */
	protected abstract function redirectURL(): string;
}
```

There are a few provided filters:
* `App\Filters\VisitorFilter` that restrict access to visitors (i.e. non connected users)
* `App\Filters\UserFilter` the dual of `VisitorFilter` (i.e. only connected users)
* `App\Filters\LogoutFilter` that is only used to have access to the logout functionality
* `App\Filters\ComposedFilter` that is used to compose filters (two by two)

There are utility functions that allow to construct filters easily:
* `App\Filters\filter(string $class)` that constructs a filter from its classname
* `App\Filters\composeFilters(array $filterClasses)` that constructs a composed filters that combines all the filters (constructed from their classnames)

For instance:
```php
$app->get("/admin/dashboard", function(){})
	->add(filter(AdminFilter::class));

$app->get("/post/{__post}", function(){})
	->add(composeFilters([
		UserFilter::class,
		PostAuthorFilter::class,
	]));
```
