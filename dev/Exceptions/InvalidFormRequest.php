<?php


namespace App\Exceptions;


use Rakit\Validation\ErrorBag;

class InvalidFormRequest extends \Exception
{
	/**
	 * @var array
	 */
	protected $errors;

	public function __construct(array $errors) {
		parent::__construct("Invalid login attempt");
		$this->errors = $errors;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}
