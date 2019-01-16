<?php
namespace App\Filters;


class VisitorFilter extends Filter{
	protected function isAuthorized(): bool {
		return !$this->auth->isLoggedIn();
	}
}