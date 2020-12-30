<?php


namespace App\Filters;


use App\Helpers\HttpStatus;
use App\Models\Role;
use DI\Container;
use Psr\Container\ContainerInterface;

class HasRole extends Filter
{
	/**
	 * @var Role|null
	 */
	protected $role;

	protected function isAuthorized(): bool
	{
		return $this->role
			&& $this->auth->user()->roles()->firstWhere("name", "=", $this->role);
	}

	protected function redirectStatus(): ?int
	{
		return HttpStatus::HTTP_FORBIDDEN;
	}


	public function __construct(ContainerInterface $c, string $role = "")
	{
		parent::__construct($c);
		$this->named($role);
	}

	public function named(string $role): HasRole
	{
		return $this->for(Role::findBy("name", $role));
	}

	public function for(?Role $role = null): HasRole
	{
		$this->role = $role;
		return $this;
	}
}

/**
 * Construct a role filter
 * @param string|?Role $role The role (or role's name)
 * @return HasRole
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function hasRole($role){
	$filter = HasRole::from(resolve(Container::class));

	if($role === null || $role instanceof Role)
		return $filter->for($role);
	else
		return $filter->named($role);
}
