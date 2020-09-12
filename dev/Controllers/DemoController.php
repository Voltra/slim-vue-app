<?php


namespace App\Controllers;


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
	public function home(Request $request, Response $response){
		return $this->view->render($response, "demo.twig", [
			"phpver" => phpversion()
		]);
	}

	/**
	 * GET /user/{user}
	 * @param Request $request
	 * @param Response $response
	 * @param string $user
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function user(Request $request, Response $response, string $user){
		return $this->view->render($response, "demo2.twig", [
			"user" => $user, // $args["user"]
		]);
	}

}
