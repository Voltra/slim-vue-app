# SLIM-VUE-APP
A ready-to-start project setup for the use of Slim 3, Vue and Twig.



## Requirements

The following items are required in order to take advantage of this starter project :

* a bash-like environment (e.g. Git for Windows)
* [PHP >= 7.1.1](http://php.net/downloads.php#v7.1.26)
* [Composer](https://getcomposer.org/download/) installed globally (available from the command-line)
* [Node >= 8](https://nodejs.org/en/download/)
* [NPM >= 6](https://nodejs.org/en/download/)
* [DBMate](https://github.com/turnitin/dbmate) (and therefore [go](https://golang.org/))



## Setup

First and foremost, `clone` (or `init` from) [this repo](https://github.com/Voltra/slim-vue-app.git).

In order to have a complete setup of your development environment, run :

```bash
npm run setup
```

It will first setup the CLI tools (e.g. DBMate), then the JS dependencies, then the PHP dependencies and finally the routes.



You also have a `aliases.sh` file that contains handy command aliases that you can setup (temporarily) using :

```bash
source aliases.sh
```



The you will have to write your own `.env` file (see `.env.example`).

Then run :

```bash
dbmate up
```

It will create the DB (if needed) and apply all migrations.



## What does it provide ?

### CLI

A lot of NPM scripts to do various tasks such as :

* run tests independently
* run all tests
* install the CLI tools
* etc..



It also provides CLI command aliases via the `aliases.sh` file that can be `source`'d.



It also integrates a framework agnostic DB migration tool: DBMate. It uses raw SQL statements for migrations and has a lot of useful features.



### PHP

Because it uses composer, you have access to the whole variety of PHP libraries you can think of.

It comes with the following :

* [Slim 3](https://packagist.org/packages/slim/slim)
* [Twig](https://packagist.org/packages/slim/twig-view)
* [Laravel's DB component](https://packagist.org/packages/illuminate/database)
* [Laravel's pagination component](https://packagist.org/packages/illuminate/pagination)
* [Hassankhan's config](https://packagist.org/packages/hassankhan/config)
* [A secure random (rng) library](https://packagist.org/packages/paragonie/random-lib)
* [Session tools](https://packagist.org/packages/bryanjhv/slim-session)
* [Flash messages](https://packagist.org/packages/slim/flash)
* [Fig Cookies](https://packagist.org/packages/dflydev/fig-cookies)
* [Whoops](https://packagist.org/packages/zeuxisoo/slim-whoops)
* [DotEnv](https://packagist.org/packages/vlucas/phpdotenv)
* [PHPUnit](https://packagist.org/packages/phpunit/phpunit)
* [PHP Mock](https://packagist.org/packages/php-mock/php-mock) (and [extensions](https://packagist.org/packages/php-mock/php-mock-phpunit) for PHPUnit)



It also comes with a bit of boilerplate already setup :

* Base DB migrations for a basic auth system
* Route filters
* CSRF middleware and extensions
* Server-side FS path utilities
* Actions for
  * Authentication
  * Cookies
  * CSRF
  * Flash messages
  * Hashing
  * POST validation
  * RNG
  * Response type promotion (PSR Response to Slim Response)
* "Automatic" config loading and setup of
  * `.env` and ENV variables
  * the app's config
  * the DB component
  * the actions
  * the container tools (twig, session, flash, etc...)
  * base middlewares
  * routes "autoload"

 

And a lot more to discover (such as PHPUnit setup)!



### JS

Webpack is useful, popular, well developed and has a lot of tooling available. It has been my first choice and my only choice ever since.



This starter project provides the following :

* [Webpack](https://www.npmjs.com/package/webpack)
* [Babel](https://www.npmjs.com/package/@babel/core)
* [Vue](https://www.npmjs.com/package/vue)
* [Sass](https://www.npmjs.com/package/node-sass)
* [Jest](https://www.npmjs.com/package/jest)
* [Nightwatch](https://www.npmjs.com/package/nightwatch)
* Useful bonus libraries



#### Webpack

It has been setup to handle JS, JSX, Vue, Sass, files, etc...

It also comes with the two powerful plugins :

* manifest plugin
* clean plugin



#### Babel

Everything has been setup to use Vue+JSX+JS+ES6 (and onward) including a few plugins :

* transform class properties
* transform do expressions
* transform function bind
* transform vue jsx
* helper vue jsx merge props



#### Vue

It has been setup in a way that allows you to use Single File Components with JSX and Sass.

A few helpers (plugins, helpers, etc...) are ready to be used.

It also comes with `vuex` and `vue-router`



#### Sass

Just setup from webpack without any additional tooling but you can modify this as you wish.



#### Jest

Unit tests have configured to run on a Node environment with the correct files and ES6 (and onward) enabled thanks to `babel-jest`.



#### Nightwatch

E2E testing has grown more popular and is a very useful tool to ensure that every piece of functionality has been thoroughly and properly tested. It comes with the geckodriver for firefox as well as the Selenium JAR. This might be subject to change in the future.



#### Useful bonus libraries

Some tools are just tooooo good to be ignored.



##### Sequency

[Sequency](https://www.npmjs.com/package/sequency) is a collection manipulation library that relies on lazy evaluation to reduce computation costs.

This is a really handy tool if like me you like to write functional-ish code.



##### Compary

Comparison functions are always a bit tricky to write, [this](https://www.npmjs.com/package/compary) just makes the pain go away.



##### db.js

[This](https://www.npmjs.com/package/db.js) is a library that abstract the indexedDB technology through a Promise based interface that is really enjoyable and actually makes it feasible to interact with the indexedDB.



##### store

[This](https://www.npmjs.com/package/store) is a very lightweight wrapper around localStorage that is rather enjoyable.



##### spinner-lord

Loading can be expensive and long, why not [display something](https://www.npmjs.com/package/spinner-lord) to make the user wait in a good mood?



##### @voltra/json

A very [basic wrapper](https://www.npmjs.com/package/@voltra/json) around `fetch` that abstracts away all the pain of extracting/sending JSON via AJAX.



##### vanilla_flash

We have flash messages to display, we might as well [make them look good](https://www.npmjs.com/package/vanilla_flash) ;D!

