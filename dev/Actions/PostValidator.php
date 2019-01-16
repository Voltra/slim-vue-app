<?php
namespace App\Actions;

use Slim\Container;

class PostValidator extends Action{
	/**@var array $post*/
	protected $post;

	public function __construct(Container $container) {
		parent::__construct($container);
		$this->post = $container->request->getParsedBody();
	}


	public function required(array $keys): bool{
		return !array_diff_key(array_flip($keys), $this->post);
	}

	public function getAll(array $cfg): array{
		$ret = [];
		foreach($cfg as $key => $uconfig){
			$default = ["type" => "string", "default" => ""];
			$config = array_merge($default, $uconfig);

			$value = !array_key_exists($key, $this->post)
			? $config["default"]
			: $this->post[$key];

			switch ($config["type"]){
				case "bool":
					$value = boolval($value);
					break;

				case "int":
					$value = intval($value);
					break;

				case "float":
					$value = floatval($value);
					break;

				default:
					$value = strval($value);
					break;
			}

			$ret[] = $value;
		}
		return $ret;
	}

	public function getOrDefault(string $key, $default){
		if(array_key_exists($key, $this->post))
			return $this->post[$key];
		return $default;
	}

	public function payload(): array{
		return $this->post;
	}

}