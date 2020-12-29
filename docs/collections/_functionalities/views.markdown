---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 12
title: Views
---

[Twig 3](https://twig.symfony.com/doc/3.x/) is used as the view render engine. The twig extensions are located in the
namespace `App\Helpers\TwigExtensions` :
{% raw %}
* `AuthExtension` that adds the global `user` variable that represents the current logged-in user
* `CsrfExtension` that adds the `csrf_input()` to add the CSRF hidden field in forms
* `FlashExtension` that adds both `hasFlash(key)` and `flash(key)` functions to determiner whether there are flash messages for a given key and retrieve them
* `MjmlExtension` that adds the `mjml_to_html` filter to render MJML in your templates (for emails)
* `PathExtension` that adds several functions:
	* `partial(path)` to get the complete path to a partial
	* `layout()` to get the complete path to the main layout (e.g. to write `{% extend layout() %}`)
	* `mailLayout()` to get the complete path to the main mail layout (e.g. to write `{% extend mailLayout() %}`)
	* `module(path)` to get the complete path to a module (e.g. `{% include module("demo") %}` for `demo.twig` in the modules' folder)
	* `fromManifest(name)` and its alias `manifest(name)` to get the URL to an asset from the manifest
{% endraw %}


There are also the [slim/twig-view](https://github.com/slimphp/Twig-View) extension and the native debug extension.

The views are located in `dev/views/`. You can find partials and layouts in `dev/views/.partials` :
* layouts at the root of that folder
	* `layout.twig` the default layout for web pages
		* it exposes the following blocks:
			* `tags` as an inline block (content of the keywords' meta tag)
			* `title` as an inline block (for the `<title>`)
			* `css` to add additional stylesheets
			* `js` to add additional scripts
			* `body` for the actual body (wrapped inside `div#add`)
	* `mail.twig` the default layout for emails (uses [MJML](https://mjml.io/documentation/))
		* it exposes the following blocks:
			* `mjmlAttr` as an inline block for the attributes of the `<mjml>` tag
			* `title` as an inline block for the `<mj-title>` content (defaults to the mail's subject)
			* `mjAttributes` for the content of the `<mj-attributes>` tag
			* `head` to add content to the `<mj-head>`
			* `bodyAttr` as an inline block for the attributes of the `<mj-body>` tag
			* `body` as the content of the `<mj-body>` tag
		* this is the default payload:
			* `msg`
				* `subject` as an optional string
				* `title` an alias for the subject
				* `from` an array of objects
					* `addr` the email address of the sender
					* `name` the name of the sender
				* `to` an array of objects
					* `addr` the email address of the receiver
					* `name` the name of the receiver
				* `replyTo` an array of objects
					* `addr` the email address of the person to reply to
					* `name` the name of the person to reply to
				* `cc` an array of objects
					* `addr` the email address of the person in carbon copy
					* `name` the name of the person in carbon copy
				* `date` a `DateTimeInterface` of when the mail is being sent
* partials in the `module` subfolder
	* `demo` that constructs the demo nav bar
	* `favicons` that loads all the generated favicons
	* `flash` that displays each flash message
	* `globalCSS` that loads the global stylesheets
	* `globalJS` that loads the global scripts
