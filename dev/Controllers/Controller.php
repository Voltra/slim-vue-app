<?php


namespace App\Controllers;


use App\Actions\Flash;
use App\Actions\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class Controller
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @var Twig
	 */
	protected $view;

	/**
	 * @var Response
	 */
	protected $responseUtils;

	/**
	 * @var Flash|mixed
	 */
	protected $flash;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->view = $container->get(Twig::class);
		$this->responseUtils = $container->get(Response::class);
		$this->flash = $container->get(Flash::class);
	}

	protected function redirectHome(ResponseInterface $res, array $params = [], array $qs = []){
		return $this->responseUtils->redirectToRoute($res, "home", $params, $qs);
	}
}
