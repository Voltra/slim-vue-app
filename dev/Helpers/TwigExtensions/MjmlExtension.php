<?php


namespace App\Helpers\TwigExtensions;


use Qferrer\Mjml\Renderer\RendererInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MjmlExtension extends AbstractExtension
{
	/**
	 * @var RendererInterface
	 */
	protected $renderer;

	public function __construct(RendererInterface $renderer)
	{
		$this->renderer = $renderer;
	}

	public function getFilters()
	{
		return [
			new TwigFilter("mjml_to_html", [$this, "render"], ["is_safe" => ["all"]]),
		];
	}

	/**
	 * @param string $content
	 * @return string
	 */
	public function render(string $content){
		return $this->renderer->render($content);
	}
}
