---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 6
title: Route model binding
---

As per the [the config]({{ "functionalities/config#routemodelbinding" | relative_url }}), route model binding allows
to autowire models from the URL parameters (not the query string). It works almost like [Laravel's](https://laravel.com/docs/8.x/routing#route-model-binding)
but with many key differences:
* It has naming issues due to the integration of PHP-DI with Slim (e.g. you have to use something like `{__user}` to bind `User $user` as if you used `{user}` it would give you the value of the route parameter)
* There is currently no way to manually customize the key/column on the fly
* There is currently no way to customize the binding resolution process
* There is no way to introduce scoping (i.e. `/user/{__user}/posts/{__post}` would not be able to ensure that the `Post` instance actually belongs to the `User` instance)

It allows to reduce the amount of boilerplate you have to write to interact with the database on a per request basis.
Note that if the binding fails (i.e. cannot be found) it throws a `App\Exceptions\RouteModelBindingFailure`.

Note that the resolved model is available everywhere (since it's added to the DI container) that is accessed after route resolution.
