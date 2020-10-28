<?php

namespace App\Actions;

use App\Config\Config;
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
	 * Action constructor.
	 * @param Container $container
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->config = $this->container->get("config");
	}

	public static function from(...$args)
	{
		return new static(...$args);
	}
};
