<?php


namespace App\Events\User;


use App\Events\Event;
use App\Models\User;

abstract class UserEvent extends Event
{
	/**
	 * @var User
	 */
	protected $user;

	public function __construct(?User $user)
	{
		parent::__construct();
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}
}
