<?php


namespace App\Events\Database;


use App\Events\Event;
use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseEvent extends Event
{
	/**
	 * @var Capsule
	 */
	protected $db;

	public function __construct(Capsule $db)
	{
		parent::__construct();
		$this->db = $db;
	}

	/**
	 * @return Capsule
	 */
	public function getDb(): Capsule
	{
		return $this->db;
	}
}
