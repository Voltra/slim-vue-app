<?php
namespace App\Filters;


use Slim\Http\StatusCode;

class UserFilter extends Filter{
	protected function isAuthorized(): bool {
		return $this->auth->isLoggedIn();
	}

	protected function redirectURL(): string {
		return $this->router->pathFor("login");
	}
}