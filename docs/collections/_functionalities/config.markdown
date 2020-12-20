---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 2
title: Config
---

In the directory `dev/Config` (namespace is `App\Config`) there are two configuration files :
* development
* production

These allow to configure your app directly in PHP via an associative array.

There are different sections and here are the details :

## debug
No additional data here, just enables global debug mode for your app. Set to `true` or `false`.
//TODO: report usage of this option

## settings
Global Slim settings:
* `name`: The app's name
* `debug`: Whether to enable debug mode
* `displayErrorDetails`: Whether to display the errors' details
* `logErrors`: Whether to log errors
* `logErrorDetails`: Whether to log the errors' details

## logs
Logger settings:
* `name`: The logging channel's name
* `path`: Path to the logs' file (as resolved by `App\Helpers\Path::root()`)
* `level`: The log level (cf. [Monolog's log levels](https://github.com/Seldaek/monolog/blob/HEAD/doc/01-usage.md#log-levels))

## views
Twig related settings (see [Twig 3.0](https://twig.symfony.com/doc/3.x/api.html#environment-options) for more info):
* `cache`: Whether to enable caching
* `debug`: Whether to enable debug mode

## csrf
CSRF configuration data:
* `key`: The key to use for meta tags and input detection

## random
Configuration for random data generation:
* `length`: The length of the random strings
* `alphabet`: A string containing the entire alphabet of characters to use (or `null` for default alphabet)

## session
PHP's default session's settings:
```php
$defaults = [
	'lifetime' => '20 minutes',
	'path' => '/',
	'domain' => '',
	'secure' => false,
	'httponly' => false,
	'samesite' => 'Lax',
	'name' => 'slim_session',
	'autorefresh' => false,
	// [...]
];
```

* `lifetime`: the lifetime of the session cookie
* `path`: the path from which the session cookie is valid
* `domain`: the domain from which the session cookie is valid
* `secure`: whether the cookie should only be valid for HTTPS
* `httponly`: whether the cookie is only available through HTTP requests
* `samesite`: the restriction policy for same site cookies
* `name`: the session cookie's name
* `autorefresh`: whether to auto refresh the cookie or not

## hash
The configuration for both hashing algorithms (password and simple):
* `algo`: the algorithm to use for passwords (cf. [password_hash](https://www.php.net/manual/fr/function.password-hash.php))
* `cost`: the cost used by the password algorithm
* `alt_algo`: the algorithm used for simple hashing

## auth
The configuration for the auth scaffold:
* `container`: the key to use to store data in the container
* `session`: the key to use to store data in the session
* `remember_name`: the remember cookie's name
* `remember_exp`: the remember cookie's expiration
* `cookie_separator`: a simple string used as a separator in the remember cookie

## db
The [Eloquent database options](https://github.com/illuminate/database#usage-instructions):
* `driver`: which database driver to use (e.g. mysql)
* `host`: the database server IP
* `port`: the port to the database server
* `database`: the database's name
* `username`: the username to use to connect to the database
* `password`: the password to use to connect to the database
* `charset`: the database's charset
* `collation`: the database's collation
* `prefix` the table prefix to use

## routeModelBinding
The configurations for the View Model Binding.
It is an associative array that maps route parameters aliases to their resolution array.

A resolution array has these properties:
* `model`: the Eloquent model class name
* `column`: the column to find the instance by

For instance :
```php
// in the config
[
	"__user" => [
		"model" => \App\Models\User::class,
		"column" => "username",
	],
];

// in the routes
$app->get("/user/{__user}", static function(Request $req, Response $res, User $user){
	// here $user is the user with the username from the route parameter __user
});
```

If the resolution fails it throws a `Slim\Exceptions\HttpNotFoundException`.

More details on this mechanism in [its dedicated page](//TODO: URL).

## redirect

Configuration for the redirectable routes:
* `mode`: "qs" for query string parameter, "body" for request body parameter
* `key`: the parameter name for the redirect URL
* `attribute`: the name of the request attribute used to mark redirection

## 2fa
The configuration for the [2FA scaffold](https://github.com/RobThree/TwoFactorAuth#usage):
* `issuer`: the 2FA code issuer (usually the app's name or the domain URL)
* `algo`: the algorithm to use to generate codes
* `digits`: the amount of digits to generate per code
* `qr_provider`: the class name of the QR code provider
* `label_field`: the field in the user table to use as label for QR codes

## mail
The mailer configuration:
* `type`: the type of [transport](https://symfony.com/doc/current/mailer.html#transport-setup) to use
* `host`: the mailer host
* `port`: the mailer port
* `username`: the username to use to log in to the mailer
* `password`: the password to use to log in to the mailer
* `mjml_exe`: the absolute path to the [MJML binary](https://www.npmjs.com/package/mjml#command-line-interface)
* `from`: the sender's info
	* `addr`: the sender's email address
	* `name`: the sender's name
* `reply_to`: where to reply to the automatic mails
	* `addr`: the reply email address
	* `name`: the reply name

## errors
The errors and exceptions configuration :
* `delegate`: whether to delegate uncaught exceptions to middlewares (from `App\Handlers\UnhandledExceptionHandler`)
