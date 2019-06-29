<?php
namespace App\Helpers\TwigExtensions;


use Slim\Container;
use Twig_SimpleFunction;

class CsrfExtension extends \Twig_Extension{
	/**@var Container $container*/
	protected $container;

	public const KEY = "csrf_key";
	public const TOKEN = "csrf_token";

	public function __construct(Container $container) {
		$this->container = $container;
	}

	public function getFunctions() {
		return [
			new Twig_SimpleFunction("csrf_input", [$this, "csrfInput"], [
				"is_safe" => ["html"]
			])
		];
	}

	protected function key(): string{
		return $this->container->view[self::KEY];
	}

	protected function token(): string{
		return $this->container->view[self::TOKEN];
	}

	public function csrfInput(): string{
		$key = $this->key();
		$token = $this->token();
		return "<input type='hidden' name='$key' value='$token'/>";
	}
}