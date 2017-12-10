# SLIM-VUE-APP
A ready-to-start project (w/ demos) for applications written using Slim, Twig and Vue

[TOC]

## Requirements

To use this tool at its full potential, you will need :

* [NodeJS](https://nodejs.org/en/) (for NPM)
* [git](https://git-scm.com/downloads)

## How to install ?
Simply follow those steps:

### Cloning the repository

`git clone https://github.com/Voltra/slim-vue-app my/project/directory`

### Installing dependencies

`npm run setup`

### Setting up handy aliases

For Shell based terminals : `source aliases.sh`



This will setup a few aliases :

* `phpunit` (runs the tests given the `phpunit.xml` configuration file)
* `punit` (same as above but uses textdox as the console output format)
* `dumpRouteLoader` (generates the `route_autoload.php` file in the `dev` folder from all the PHP files contained in the `dev/routes` folder)



Note that each time you start a new terminal session, you have to set these aliases again (unless you source the aliases file in a file like `~/.bashrc`).

## What is installed ?

This project installs the following PHP dependencies:

* [Slim](https://packagist.org/packages/slim/slim)
* [Twig Views for Slim](https://packagist.org/packages/slim/twig-view)
* [PHPUnit](https://packagist.org/packages/phpunit/phpunit)
* [PHP-mock](https://packagist.org/packages/php-mock/php-mock)
* [Hassankhan's Config](https://packagist.org/packages/hassankhan/config)
* [Laravel's Database component](https://packagist.org/packages/illuminate/database)



As well as the following JS dependencies:

* [Webpack](https://webpack.js.org/) and several loaders
* [Babel](https://babeljs.io/)
* [cross-env](https://www.npmjs.com/package/cross-env)
* [Vue](https://www.npmjs.com/package/vue)



## How to build ?

There are a few [npm scripts]() that you can use:

* `dev-build` : bundles for development
* `dev-watch`: bundles for development and will rebundle automatically after changes
* `prod-build`: bundles for production