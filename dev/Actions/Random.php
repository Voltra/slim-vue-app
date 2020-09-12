<?php

namespace App\Actions;


use RandomLib\Factory as GeneratorFactory;
use RandomLib\Generator;
use DI\Container;

class Random extends Action
{
	/**@var int $length*/
	protected $length;

	/**@var Generator $generator*/
	protected $generator;

	/**@var string $alphabet*/
	protected $alphabet;

	public function __construct(Container $container)
	{
		parent::__construct($container);
		$config = $this->container->get("config")["random"];

		$this->length = $config["length"];
		$this->alphabet = $config["alphabet"];

		$factory = new GeneratorFactory();
		$this->generator = $factory->getMediumStrengthGenerator();
	}

	public function generateString(): string
	{
		if (empty($this->alphabet))
			return $this->generator->generateString($this->length);

		return $this->generator->generateString($this->length, $this->alphabet);
	}
}
