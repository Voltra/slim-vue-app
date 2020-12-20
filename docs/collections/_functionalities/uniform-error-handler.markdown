---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 4
title: Uniform error handler
---

The `App\Handlers\UniformErrorHandler` error handler allows handling specific exceptions via a specific callback.
These callbacks are configured in `dev/container/errors.php`.
A callback accepts the exception as its first parameter and the request as its second, it must return a response:
```php

use Psr\Http\Message\ServerRequestInterface as Request;
use App\Exceptions\InvalidFormRequest;
use Slim\Psr7\Response;

[
	InvalidFormRequest::class => static function(InvalidFormRequest $e, Request $req): Response{
		// handle the exception here
		// return the appropriate response
	},
];
```
