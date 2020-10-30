<?php

namespace App\Actions;


use DI\Container;
use Slim\Flash\Messages as FlashMessages;

class Flash extends Action
{
	public const SUCCESS = "success";
	public const FAILURE = "failure";
	public const INFO = "info";

	/**@var FlashMessages $flash*/
	protected $flash;

	public $now;

	public function __construct(Container $container)
	{
		parent::__construct($container);

		$this->flash = $container->get("flash");

		$this->now = new class ($this->flash)
		{
			protected $flash;
			public function __construct(FlashMessages $flash)
			{
				$this->flash = $flash;
			}

			public function success(string $msg): void
			{
				$this->flash->addMessageNow(Flash::SUCCESS, $msg);
			}
			public function failure(string $msg): void
			{
				$this->flash->addMessageNow(Flash::FAILURE, $msg);
			}
			public function info(string $msg): void
			{
				$this->flash->addMessageNow(Flash::INFO, $msg);
			}
		};
	}

	public function success(string $msg): void
	{
		$this->flash->addMessage(self::SUCCESS, $msg);
	}
	public function failure(string $msg): void
	{
		$this->flash->addMessage(self::FAILURE, $msg);
	}
	public function info(string $msg): void
	{
		$this->flash->addMessage(self::INFO, $msg);
	}
}
