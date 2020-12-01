<?php


namespace App\Exceptions;


use Throwable;

class CannotRegisterUser extends \Exception
{
	protected const DEFAULT_ERR_MSG = "Username already taken";

	public function __construct() {
		parent::__construct("Username already taken");
	}
}
