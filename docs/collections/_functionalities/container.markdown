---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 3
title: Container
---

The container's setup is located in `dev/container/definitions.php`. It is separated in different parts for readability:
* `Via keys` which defines dependencies with human-readable keys (e.g. `config` or `session`)
* `Via class strings` which defines dependencies based on their class names (e.g. `Psr\Log\LoggerInterface::class`)
* `Actions` which autowires action classes
* `Filters` which autowires route filters
* `Utils` which autowires utility classes

It allows for constructor injection only (except for controller methods which are resolved separately).
There is also the handy `resolve` global function that allows to get anything from the container from anywhere.

The container also declares the handling of specific exceptions through the [`App\Handlers\UniformErrorHandler`]({{ 'functionalities/uniform-error-handler' | relative_url }}).
