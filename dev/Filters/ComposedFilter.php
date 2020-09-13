<?php
namespace App\Filters;


use Psr\Container\ContainerInterface;

class ComposedFilter extends Filter{
	protected $lhs;
	protected $rhs;

	public function __construct(ContainerInterface $c, Filter $lhs, Filter $rhs) {
		parent::__construct($c);
		$this->lhs = $lhs;
		$this->rhs = $rhs;
	}

	protected function isAuthorized(): bool {
		return $this->lhsAuthorizes() && $this->rhsAuthorizes();
	}

	protected function redirectURL(): string {
		return $this->lhsAuthorizes()
		? $this->rhsURL()
		: $this->lhsURL();
	}

	protected function redirectStatus(): int {
		return $this->lhsAuthorizes()
		? $this->rhsStatus()
		: $this->lhsStatus();
	}

	protected function lhsAuthorizes(): bool{
		return $this->lhs->isAuthorized();
	}

	protected function rhsAuthorizes(): bool{
		return $this->rhs->isAuthorized();
	}

	protected function lhsURL(): string{
		return $this->lhs->redirectURL();
	}

	protected function rhsURL(): string{
		return $this->rhs->redirectURL();
	}

	protected function lhsStatus(): int{
		return $this->lhs->redirectStatus();
	}

	protected function rhsStatus(): int{
		return $this->rhs->redirectStatus();
	}
}

/**
 * Compose a series of filters (left associative)
 * @param string[] $filterClasses - The class names of the filters to compose (will be resolved via the DI container)
 * @return ComposedFilter|Filter
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function composeFilters($filterClasses){
	/**
	 * @var Filter $composedFilter
	 */
	$composedFilter = resolve($filterClasses[0]);

	for($i = 1, $length = count($filterClasses) ; $i < $length ; ++$i){
		/**
		 * @var Filter $filter
		 */
		$filter = resolve($filterClasses[$i]);

		$composedFilter = $composedFilter->composeWith($filter);
	}

	return $composedFilter;
}
