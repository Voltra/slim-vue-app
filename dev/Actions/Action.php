<?php

namespace App\Actions;

use App\Config\Config;
use DI\Container;
use SlimSession\Helper as Session;

abstract class Action
{
	/**@var Container $container*/
	protected $container;

	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * @var Session
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
