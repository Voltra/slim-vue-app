<?php
namespace App\Filters;

class AdminFilter extends Filter{
	protected function isAuthorized(): bool {
		return $this->auth->isAdmin();
	}

	/*protected function redirectURL(): string {
		return $this->auth->isLoggedIn()
		? parent::redirectURL()
		: $this->router->pathFor("login");
	}*/
}