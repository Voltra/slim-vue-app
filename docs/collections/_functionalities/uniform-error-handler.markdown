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
use App\Exceptions\MyException;
use Slim\Psr7\Response;

[
	MyException::class => static function(MyException $e, Request $req): Response{
		// handle the exception here
		// return the appropriate response
	},
];
```

For instance, this allows to redirect back with errors on `App\Exceptions\InvalidFormRequest` or to throw the
usual `Slim\Exception\HttpInternalServerErrorException` on container exceptions.

Note that legacy PHP internal errors are all handled by `App\Handlers\LegacyPhpErrorHandler` and throw back a
`App\Exceptions\LegacyPhpError`.
