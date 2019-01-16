<?php
namespace App\Actions;

use Slim\Container;
use SlimSession\Helper as Session;

class Csrf extends Action{
	/**@var string $key*/
	protected $key;

	/**@var Random $random*/
	protected $random;

	/**@var Session $session*/
	protected $session;

	/**@var Hash $hash*/
	protected $hash;

	public function __construct(Container $container) {
		parent::__construct($container);
		$config = $this->container["config"]["csrf"];

		$this->key = $config["key"];
		$this->session = $this->container["session"];

		/*$this->random = Random::from($container);
		$this->hash = Hash::from($container);*/
		$this->random = $container->get(Random::class);
		$this->hash = $container->get(Hash::class);
	}

	public function sessionKey(): string{
		return $this->key;
	}

	public function formKey(): string{
		return $this->sessionKey();
	}

	public function hasToken(): bool{
		return $this->session->exists($this->sessionKey());
	}

	public function getToken(): string{
		$this->ensureHasToken();
		return $this->session->get($this->sessionKey());
	}

	public function generateNewToken(): string{
		$token = $this->hash->hash(
			$this->random->generateString()
		);
		$this->session->set($this->sessionKey(), $token);
		return $token;
	}

	public function isValid(string $token): bool{
		$actualToken = $this->getToken();
		return $this->hash->checkHash($token, $actualToken);
	}

	public function ensureHasToken(): void{
		if(!$this->hasToken())
			$this->generateNewToken();
	}
}