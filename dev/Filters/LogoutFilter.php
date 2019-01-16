<?php
namespace App\Filters;


class LogoutFilter extends Filter{
	protected function isAuthorized(): bool {
		return $this->auth->isLoggedIn();
	}
}