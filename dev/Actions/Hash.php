<?php
namespace App\Actions;

use Slim\Container;

class Hash extends Action {
	protected $algo, $cost, $alt;

	public function __construct(Container $container) {
		parent::__construct($container);
		$config = $container["config"]["hash"];

		$this->algo = $config["algo"];
		$this->cost = $config["cost"];
		$this->alt = $config["alt_algo"];
	}

	public function hashPassword(string $password): string{
		return password_hash($password, $this->algo, [
			"cost" => $this->cost
		]);
	}

	public function checkPassword(string $password, string $hash): bool{
		return password_verify($password, $hash);
	}

	public function hash(string $input): string{
		return hash($this->alt, $input);
	}

	public function checkHash(string $knowHash, string $desiredHash): bool{
		return hash_equals($knowHash, $desiredHash);
	}
}