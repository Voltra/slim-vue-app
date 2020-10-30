<?php


namespace App\Helpers\TwigExtensions;


use App\Actions\Auth;
use App\Models\User;
use DI\Container;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AuthExtension extends AbstractExtension implements GlobalsInterface
{

	/**
	 * @var Container
	 */
	protected $container;
	/**
	 * @var Auth
	 */
	protected $auth;

	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->auth = $container->get(Auth::class);
	}

	public function getGlobals(): array
	{
		return [
			"user" => $this->auth->user(),
		];
	}
}
