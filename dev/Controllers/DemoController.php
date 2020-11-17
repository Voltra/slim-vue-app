<?php


namespace App\Controllers;


use App\Actions\FileSystem;
use App\Models\User;
use DI\DependencyException;
use DI\NotFoundException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\FileNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DemoController extends Controller
{
	/**
	 * GET /
	 * @param Response $response
	 * @param Request $request
	 * @return Response
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws FileNotFoundException
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function home(Response $response, Request $request){
		// thx to the PHP-DI bridge, we can inject arguments however we want

		$fs = $this->container->get(FileSystem::class);
		$json = $fs->for(Local::class)->read("demo.json");

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
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
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
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function vmb(Request $request, Response $response, User $user){
		return $this->view->render($response, "demo3.twig", compact(
			"user"
		));
	}
}
