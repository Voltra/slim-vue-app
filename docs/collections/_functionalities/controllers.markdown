---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 8
title: Controllers
---

In addition to closures, you may also use a controller to group your methods. Controllers are defined in `App\Controllers`
and may extend from `App\Controllers\Controller`. Due to how the DI container is tied to Slim, controller methods have more
flexibility compared to closures (on how parameters are injected, closures need the request and response as the first parameters).

There is a helper function `App\controllerMethod(string $controllerClass, string $method)` (with an alias `App\cm(string $controllerClass, string $method)`)
that allows to register method handlers.

For instance, the `App\Controllers\AuthController` defines all the methods for the auth scaffolding:
```php
class AuthController extends Controller{
	// [...]

	/**
	 * POST /auth/login
	 */
	public function login(LoginRequest $form, Response $response){}

	// [...]
}

$app->post("/auth/login", cm(AuthController::class, "login"));
```
