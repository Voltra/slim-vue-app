<?php


namespace App\Controllers;


use App\Actions\FileSystem;
use App\Actions\TwoFactor;
use App\Events\DemoEvent;
use App\Events\Events;
use App\Helpers\Path;
use App\Models\User;
use League\Flysystem\Adapter\Local;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DemoController extends Controller
{
	/**
	 * GET /
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function home(Response $response, Request $request){
		// thx to the PHP-DI bridge, we can inject arguments however we want

		$fs = $this->container->get(FileSystem::class);
		$json = $fs->for(Local::class)->read("demo.json");

		Events::trigger(new DemoEvent("world"));

		return $this->view->render($response, "demo.twig", [
			"phpver" => phpversion(),
			"json" => $json,
		]);
	}

	/**
	 * GET /user/{user_}
	 * @param Request $request
	 * @param Response $response
	 * @param string $user
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function user(Request $request, Response $response, string $user){
		// $user is the {user} route parameter
		return $this->view->render($response, "demo2.twig", compact(
			"user"
		));
	}

	/**
	 * GET /vmb/{user}
	 * @param Request $request
	 * @param Response $response
	 * @param User $user
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function vmb(Request $request, Response $response, User $user){
		return $this->view->render($response, "demo3.twig", compact(
			"user"
		));
	}
}
