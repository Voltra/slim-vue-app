<?php

namespace App\Helpers\TwigExtensions;

use Slim\Flash\Messages as FlashMessages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


//cf. https://raw.githubusercontent.com/kanellov/slim-twig-flash/master/src/TwigMessages.php
class FlashExtension extends AbstractExtension
{
	/**
	 * @var FlashMessages
	 */
	protected $flash;

	public function __construct(FlashMessages $flash)
	{
		$this->flash = $flash;
	}

	/**
	 * Extension name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return "slim-twig-flash";
	}

	/**
	 * Callback for twig.
	 *
	 * @return array
	 */
	public function getFunctions()
	{
		return [
			new TwigFunction("flash", [$this, "getMessages"]),
			new TwigFunction("hasFlash", [$this, "hasMessages"]),
		];
	}

	public function hasMessages($key){
		return $this->flash->hasMessage($key);
	}

	/**
	 * Returns Flash messages; If key is provided then returns messages
	 * for that key.
	 * @param string|null $key
	 * @return array
	 */
	public function getMessages($key = null)
	{
		if (null !== $key) {
			return $this->flash->getMessage($key);
		}

		return $this->flash->getMessages();
	}
}
