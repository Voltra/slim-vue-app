---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 10
title: Middlewares
---

Due to a recent change in core, Slim now follows [PSR-15](https://www.php-fig.org/psr/psr-15/) which means that all
middlewares had to be rewritten. Middlewares are located in `App\Middlewares` and extend from `App\Middlewares\Middleware`.

Here is the basic API:
```php
abstract class Middleware{
	/**@var ContainerInterface $container*/
	protected $container;

	public function __construct(ContainerInterface $container){}

	public abstract function process(Request $req, RequestHandlerInterface $handler): ResponseInterface;
}
```

There are already a few defined:
* `App\Middlewares\AcceptsRedirect` tags a route to accept redirect URLs (prevents "any redirect" attack)
* `App\Middlewares\Auth` that handle logging in from a remember token
* `App\Middlewares\BackUrl` that saves the last visited page (to allow redirecting to a previous page)
* `App\Middlewares\Csrf` that enforces CSRF checks and allows generating tokens to put them in forms
* `App\Middlewares\FormRequestErrors` that adds the previous form request errors to the global view data
* `App\Middlewares\RedirectAfterRequest` that automatically redirects after processing the request (i.e. redirectable routes)
* `App\Middlewares\RequestBinding` that put the request in the DI container
* `App\Middlewares\Requires2FA` marks the route as requiring 2FA (i.e. a 2FA code in the request body) and handles the checks
* `App\Middlewares\RouteModelBinding` that processes the route model bindings
* `App\Middlewares\UniformErrorHandling` that uses the [uniform error handler]({{ "functionalities/uniform-error-handler" | relative_url }}) to handle exceptions
