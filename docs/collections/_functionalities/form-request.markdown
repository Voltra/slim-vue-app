---
layout: home
parent: Functionalities
nav_order: 5
title: Form request
---

In `App\Requests` you can define form requests which are a specific kind of requests that embeds validation and sanitization.
These are classes that extend from `App\Requests\FormRequest` which provides "hooks" to customize validation, sanitization,
data retrieval and error messages. It uses [rakit/validation](https://packagist.org/packages/rakit/validation) to handle validation
so make sure to get familiar with it to make the most of it.

This is the customization API:
```php
abstract class FormRequest{
	/**
	 * @var ServerRequestInterface
	 */
	protected $request;

	/**
	 * @var Validation|null
	 */
	protected $validation;

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * Sanitize the input data
	 * @param array $data
	 */
	public abstract function sanitize(array $data);

	/**
	 * Retrieve the data to validate
	 * @returns array
	 */
	public abstract function data(): array;

	/**
	 * The validation rules for the input data
	 * @returns array
	 */
	public abstract function rules(): array;

	/**
	 * The error messages for the input data
	 * @returns array
	 */
	public abstract function messages(): array;
}
```


Note that the validation happens in the constructor (to hook properly with both the router and DI container).
If the validation fails it throws an `App\Exceptions\InvalidFormRequest` (which has default error handling, see [uniform error handler]({{ 'functionalities/uniform-error-handler' | relative_url }})) otherwise it calls the route handler.


This is highly inspired by the [same concept from Laravel](https://laravel.com/docs/8.x/validation#form-request-validation).
The first thing you might want to do in your route handler is to retrieve the validated data with `$formRequest->validatedData()`.
