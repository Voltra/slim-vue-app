<?php
namespace App\Filters;

use DI\DependencyException;
use DI\NotFoundException;
use Throwable;

class AdminFilter extends Filter{
	protected function isAuthorized(): bool {
		return $this->auth->isAdmin();
	}

	/*protected function redirectURL(): string {
		return $this->auth->isLoggedIn()
		? parent::redirectURL()
		: $this->router->urlFor("login");
	}*/
}
