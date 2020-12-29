---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 9
title: Route autoloading
---

Routes are defined in `dev/routes`. These files are then collected into a single file (`dev/route_autoload.php`) using the `dumpRouteLoader` alias
defined in `aliases.sh`. If you take a look at `dev/bootstrap.php` you can see the route definition file simply `required_once` before returning
the app instance. This allows direct access to the global variables (such as `$app`).

This allows you to write as many route files as you want without having the mental overhead of combining/registering them.
Do note that the separate files are themselves `required_once` in ascending lexicographic order (based on the file path).
In general, it is a good idea to not introduce hierarchy dependencies between files but instead define these in the same file.
