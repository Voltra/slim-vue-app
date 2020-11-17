<?php


namespace App\Events;


class DemoEvent extends Event
{
	/**
	 * @var string
	 */
	protected $name;

	public function __construct(string $name)
	{
		parent::__construct();
		$this->name = $name;
	}

	public function getName(): string{
		return $this->name;
	}
}
