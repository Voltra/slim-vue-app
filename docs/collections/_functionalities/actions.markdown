---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 1
title: Actions
---

In the namespace `App\Actions` are defined a bunch of action classes.
This principle comes directly from the [Model View Endpoint Action](https://github.com/Voltra/mvea) architectural pattern.

They provide granular logic for a given purpose (e.g. authentication, hashing, csrf, etc...). This allows for higher
decoupling of logic and more re-usability.

Here's a list of the default actions and what they provide :
* `App\Actions\Auth` that allows to handle authentication for the request's user
	* register
	* login
	* logout
	* remember
	* forceful login
	* login from remember
	* retrieving the request's user
	* determine whether a user is logged in
	* handle 2FA login for a specific user
* `App\Actions\Cookies` that allows to manipulate request cookies
	* build a new cookie (see [dflydev/fig-cookies](https://github.com/dflydev/dflydev-fig-cookies#response-cookies))
	* set a cookie
	* get a cookie
	* determine whether there is a cookie for a given name
	* expire a cookie
	* remove a cookie
* `App\Actions\Csrf` that allows to handle CSRF security checks
	* determine whether the session has a token
	* get the session's token
	* generate a session
	* determine whether a token is valid compared to the session's token
	* process CSRF checks
* `App\Actions\FileSystem` that allows to manipulate different filesystem handlers
	* get a FS handler for the given adapter class (e.g. [local FS](https://flysystem.thephpleague.com/v2/docs/adapter/local/))
* `App\Actions\Flash` that allows to store/retrieve flash messages
	* success message (for the next request, for the current request)
	* failure message (for the next request, for the current request)
	* info message (for the next request, for the current request)
* `App\Actions\Hash` that allows to hash strings
	* hash a password
	* check if a password matches a given hash
	* simple hash a string
	* check if a string matches a given simple hash
* `App\Actions\Http` that allows to emit HTTP requests
	* based on [`kitetail/zttp`](https://packagist.org/packages/kitetail/zttp)
	* methods are just delegated to the `Zttp` facade
* `App\Actions\Random` that allows to generate random data
	* generate a random string (configured length and alphabet)
* `App\Actions\Response` that allows for easy response manipulation
	* upgrade a generic response to a Slim response
	* redirect to a given path
	* redirect to a given path with a given status
	* redirect to a given route (with route params and query string parameters)
	* easily send JSON data
	* redirect to the previous page
* `App\Actions\TwoFactor` that allows to handle 2FA logic
	* validate 2FA for a given user and a given code
	* create a new discriminant
	* get the QR code for a given user
	* get the secret of a given user
	* enable 2FA
	* disable 2FA
* `App\Actions\Validator` that allows to create request validators
	* create a validator from a request
	* create a validator from an array of data

All are predefined in the [container specific configuration]({{ 'functionalities/container' | relative_url }}) so that you can inject them or resolve them easily.
