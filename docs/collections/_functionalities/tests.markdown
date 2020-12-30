---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 18
title: Tests
---

Backend tests are written, under `App\Tests` which is the `test/` folder, using [PHPUnit](https://packagist.org/packages/phpunit/phpunit). Tests must inherit from
`App\Tests\PHPUnit`. This base class inherits directly from PHPUnit's `TestCase` and enriches it with
[jasny/phpunit-extension](https://packagist.org/packages/jasny/phpunit-extension) (for callback mocks, warnings and notices, private testing and safe mocks)
and [php-mock/php-mock-phpunit](https://packagist.org/packages/php-mock/php-mock-phpunit) (for mocking native functions).

This allows for parametric tests as well as semi-automatic test discovery as configured in `phpunit.xml`. It will also
provide information about code coverage.

Front-end tests will be detailed in [their own page](TODO: url for front end tests).
