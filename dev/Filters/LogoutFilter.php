<?php
namespace App\Filters;


use DI\DependencyException;
use DI\NotFoundException;
use Throwable;

class LogoutFilter extends Filter{
	protected function isAuthorized(): bool {
		return $this->auth->isLoggedIn();
	}
}
