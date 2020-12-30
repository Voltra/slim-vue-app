---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 14
title: Helpers
---

All helpers are under the namespace `App\Helpers`. Note that all URIs most start with a slash.

## AppEnv
Helper for the app's environment (note that it supports `production`, `development` and `test`). It provides static
methods to both retrieve and check which mode the app is in:
* `get(): string` returns the mode
* `dev(): bool` whether it's in development mode
* `prod(): bool` whether it's in production mode
* `testing(): bool` whether it's in test mode

Note that this value is extracted from the environment variable `PHP_ENV`.

## Carbon

An alias for [nesbot/carbon](https://packagist.org/packages/nesbot/carbon)'s `CarbonImmutable`.

Also exposes several shorthand functions:
* `App\Helpers\now()`
* `App\Helpers\today()`
* `App\Helpers\tomorrow()`
* `App\Helpers\yesterday()`
* `App\Helpers\timeAgo(Carbon $carbon)`

## Enum

A trait alias for [rikudou/enums-trait](https://packagist.org/packages/rikudou/enums-trait  )'s `EnumTrait` that provides the following interface:
```php
trait Enum
{
	use EnumTrait;

	/**
	 * The list of allowed values
	 * @see https://packagist.org/packages/rikudou/enums-trait
	 * @return array
	 */
	protected abstract static function allowedValues(): array;
}
```

This allows to define the following for instance:
```php
/**
 * @class Direction
 * @method static Direction Left()
 * @method static Direction Right()
 * @method static Direction Up()
 * @method static Direction Down()
 */
class Direction{
	use App\Helpers\Enum;

	protected static function allowedValues(): array{
		return [
			"Left",
			"Right",
			"Up",
			"Down",
		];
	}
}
```

## Env

It's just an alias for [Laravel's Env](https://laravel.com/api/8.x/Illuminate/Support/Env.html).

## HassankhanConfig

An alias for [hassankhan/config](https://packagist.org/packages/hassankhan/config)'s `Config`.

## HttpStatus

An alias for [lukasoppermann/http-status](https://packagist.org/packages/lukasoppermann/http-status)'s `Httpstatuscodes`

## Path
**NB:** Windows has supported forward slashes in paths for a while now, therefore do not use backlashes.

`App\Helpers\Path` provides lots of static methods to get absolute paths to files on the server:
* `root($uri = ""): string` for paths from the root of the project
* `dev($uri = ""): string` for paths from the `dev` folder
* `public($uri = ""): string` for paths from the `public_html` folder
* `assets($uri = ""): string` for paths from the `public_html/assets` folder
* `tmp($uri = ""): string` for paths from the `tmp` folder
* `cache($uri = ""): string` for paths from the `tmp/cache` folder
* `uploads($uri = ""): string` for paths from the `public_html/uploads` folder

## Routing

The implementation of the helper functions `cm` and `controllerMethod` but as static methods.

## Session

An alias for [bryanjhv/slim-session]()'s `Helper`.

## Stream

An alias for [voltra/lazy-collection](https://packagist.org/packages/voltra/lazy-collection)'s `Stream`.

## UserResponsePair

A pair type that stores both a `App\Models\User` and `Slim\Psr7\Response`. These are exposed under the readonly properties
`$pair->user` and `$pair->response`. You can also destructure its array form: `[$response, $user] = $pair->asArray()`.
