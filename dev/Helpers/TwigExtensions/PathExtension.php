<?php

namespace App\Helpers\TwigExtensions;


use App\Helpers\Path;
use DI\Container;
use Illuminate\Filesystem\Filesystem;
use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig_SimpleFunction;

class PathExtension extends AbstractExtension
{
	/**
	 * @var array
	 */
	protected $manifest;

	/**
	 * PathExtension constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->manifest = $container->get("manifest");
	}

	public function getFunctions()
	{
		return [
			new TwigFunction("partial", [$this, "partial"]),
			new TwigFunction("layout", [$this, "layout"]),
			new TwigFunction("module", [$this, "module"]),
			new TwigFunction("fromManifest", [$this, "fromManifest"]),
			new TwigFunction("manifest", [$this, "fromManifest"]),
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

	public function fromManifest(string $entry): string{
		return $this->manifest[$entry] ?? "";
	}
}
