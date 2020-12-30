---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 13
title: Emails
---

Emails are made possible by using the [Symfony Mailer](https://packagist.org/packages/symfony/mailer) and specializing it
to our needs. As emails are extremely annoying to work with, [MJML](https://mjml.io/documentation/) is integrated by default.

As mentioned in the [views]({{ "functionalities/views" | relative_url }}) section, there's a separate layout for emails.
You must store your email templates in `dev/views/mails` (as helpers rely on this folder structure).

Emails are stored in the `App\Mails` directory and must extend `App\Mails\Mail`:
```php
class Mail extends TemplatedEmail{
	public static function create(...$args): self{}

	/**
	 * Set the template URI relative to the mails' templates directory
	 * @param string $uri
	 * @return Mail
	 */
	public function template(string $uri): self{}

	/**
	 * Render and send the email
	 * @param array $context The additional context for the Twig template
	 * @throws TransportExceptionInterface
	 */
	public function send(array $context = []): void{}

	/**
	 * Mail constructor.
	 * @param Headers|null $headers
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function __construct(?Headers $headers = null){}

	/**
	 * Prepare this Mail instance
	 */
	protected function initialSetup(): void{}
}

Mail::create()
	->subject("Demo mail")
	->to(new Address("test@test.test", "Test Dude"))
	->template("demo.mjml.twig") // points to dev/views/mails/demo.mjml.twig
	->send();
```

Custom messages may override the constructor for additional parameters and `initialSetup` to prepare the mail instance.
