<?php


namespace App\Exceptions;


class InvalidLoginAttempt extends \Exception
{
	public function __construct() {
		parent::__construct("Invalid login attempt");
	}
}
