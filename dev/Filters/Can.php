<?php


namespace App\Filters;


use App\Helpers\HttpStatus;
use App\Models\Permission;
use DI\Container;
use Psr\Container\ContainerInterface;
use function Symfony\Component\Translation\t;

class Can extends Filter
{
	/**
	 * @return bool
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	protected function isAuthorized(): bool
	{
		return $this->permission
			&& $this->auth->user()->permissions()->contains($this->permission);
	}

	protected function redirectStatus(): ?int
	{
		return HttpStatus::HTTP_FORBIDDEN;
	}


	/**
	 * @var Permission|null
	 */
	protected $permission;

	public function __construct(ContainerInterface $c, string $permission = "")
	{
		parent::__construct($c);
		$this->do($permission);
		$this->permission = Permission::findBy("name", $permission);
	}

	/**
	 * Set the permission of the filter
	 * @param string $permission
	 * @return $this
	 */
	public function do(string $permission): Can
	{
		return $this->for(Permission::findBy("name", $permission));
	}

	/**
	 * Set the permission of the filter
	 * @param Permission|null $permission
	 * @return $this
	 */
	public function for(?Permission $permission = null){
		$this->permission = $permission;
		return $this;
	}
}

/**
 * Construct a permission filter
 * @param string|?Permission $permission The permission (or permission's name)
 * @return Can|Filter
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function can($permission){
	$filter = Can::from(resolve(Container::class));

	if($permission === null || $permission instanceof Permission)
		return $filter->for($permission);
	else
		return $filter->do($permission);
}
