<?php

namespace App\Actions;


use Slim\Container;
use Slim\Flash\Messages as FlashMessages;

class Flash extends Action{
	const SUCCESS = "success";
	const FAILURE = "failure";
	const INFO = "info";

	/**@var FlashMessages $flash*/
	protected $flash;

	public $now;

	public function __construct(Container $container) {
		parent::__construct($container);

		$this->flash = $container->flash;

		$this->now = new class($this->flash){
			protected $flash;
			public function __construct(FlashMessages $flash) { $this->flash = $flash; }

			public function success(string $msg){ $this->flash->addMessageNow(Flash::SUCCESS, $msg); }
			public function failure(string $msg){ $this->flash->addMessageNow(Flash::FAILURE, $msg); }
			public function info(string $msg){ $this->flash->addMessageNow(Flash::INFO, $msg); }
		};
	}

	public function success(string $msg){ $this->flash->addMessage(self::SUCCESS, $msg); }
	public function failure(string $msg){ $this->flash->addMessage(self::FAILURE, $msg); }
	public function info(string $msg){ $this->flash->addMessage(self::INFO, $msg); }
}