<?php

namespace App\Helpers\TwigExtensions;


use DI\Container;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig_SimpleFunction;

class PathExtension extends AbstractExtension
{
	public function getFunctions()
	{
		return [
			new TwigFunction("partial", [$this, "partial"]),
			new TwigFunction("layout", [$this, "layout"]),
			new TwigFunction("module", [$this, "module"]),
		];
	}

	public function partial(string $path): string
	{
		return ".partials/{$path}.twig";
	}

	public function layout(): string
	{
		return $this->partial("layout");
	}

	public function module(string $path): string
	{
		return $this->partial("modules/{$path}");
	}
}
