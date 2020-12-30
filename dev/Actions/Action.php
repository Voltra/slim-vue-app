<?php

namespace App\Actions;

use App\Config\Config;
use App\Helpers\Session;
use DI\Container;

abstract class Action
{
	/**@var Container $container*/
	protected $container;

	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * @var Session $session
	 */
	protected $session;

	/**
	 * Action constructor.
	 * @param Container $container
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->config = $this->container->get("config");
		$this->session = $this->container->get("session");
	}

	public static function from(...$args)
	{
		return new static(...$args);
	}
};
