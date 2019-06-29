<?php
namespace App\Helpers\TwigExtensions;


use Slim\Container;
use Twig_SimpleFunction;

class PathExtension extends \Twig_Extension{
	/**@var Container $container*/
//	protected $container;

	protected $basePartialPath;

	public function __construct(/*Container $container*/) {
//		$this->container = $container;
	}

	public function getFunctions() {
		return [
			new Twig_SimpleFunction("partial", [$this, "partial"]),
			new Twig_SimpleFunction("layout", [$this, "layout"]),
			new Twig_SimpleFunction("module", [$this, "module"]),
		];
	}

	public function partial(string $path): string{
//		return Path::dev("/views/.partials/") . $path;
		return ".partials/{$path}.twig";
	}

	public function layout(): string{
		return $this->partial("layout");
	}

	public function module(string $path): string{
		return $this->partial("modules/{$path}");
	}
}