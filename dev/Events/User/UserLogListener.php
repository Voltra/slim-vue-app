<?php


namespace App\Events\User;


use DI\DependencyException;
use DI\NotFoundException;
use Psr\Log\LoggerInterface;

//DEMO

class UserLogListener
{
	/**
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * UserLogListener constructor.
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function __construct()
	{
		$this->logger = resolve(LoggerInterface::class);
	}

	public function onCreate(UserCreated $event){
		$user = $event->getUser();
		$this->logger->debug("CREATE user {$user->username}");
	}

	public function onLogin(UserLoggedIn $event){
		$user = $event->getUser();
		$this->logger->debug("LOGIN user {$user->username}");
	}

	public function onLogout(UserLoggedOut $event){
		$user = $event->getUser();
		$this->logger->debug("LOGOUT user {$user->username}");
	}
}
