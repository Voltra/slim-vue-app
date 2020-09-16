<?php

namespace App\Helpers\TwigExtensions;


use DI\Container;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CsrfExtension extends AbstractExtension
{
	/**@var Container $container*/
	protected $container;

	public const KEY = "csrf_key";
	public const TOKEN = "csrf_token";

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function getFunctions()
	{
		return [
			new TwigFunction("csrf_input", [$this, "csrfInput"], [
				"is_safe" => ["html"]
			]),
		];
	}

	protected function key(): string
	{
		return $this->container->get("view")[self::KEY];
	}

	protected function token(): string
	{
		return $this->container->get("view")[self::TOKEN];
	}

	public function csrfInput(): string
	{
		$key = $this->key();
		$token = $this->token();
		return "<input type='hidden' name='$key' value='$token'/>";
	}
}
