<?php


namespace App\Controllers;

use App\Actions\Auth;
use App\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends Controller
{
	/**
	 * @var Auth|mixed
	 */
	protected $auth;

	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
		$this->auth = $container->get(Auth::class);
	}

	/**
	 * GET /auth/login
	 *
	 * @param Response $response
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function loginForm(Response $response){
		return $this->view->render($response, "auth/login.twig");
	}

	/**
	 * GET /auth/register
	 *
	 * @param Response $response
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function registerForm(Response $response){
		return $this->view->render($response, "auth/register.twig");
	}

	/**
	 * POST /auth/login
	 *
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function login(Request $request, Response $response){
		$data = $request->getParsedBody();
		//TODO: Validation
		//TODO: Form requests
		$username = $data["username"] ?? "";
		$password = $data["password"] ?? "";
		$remember = $data["remember"] ?? false;
		$code = $data["2fa"] ?? "";

		$res = $this->responseUtils->upgrade($response);

		[$newResponse, $user] = $this->auth->login(
			$res,
			$username,
			$password,
			$remember,
			$code
		)->asArray();

		if($user === null){
			$this->flash->failure("Failed to login");
			return $this->responseUtils->redirectToRoute($newResponse, "auth.login", [
				"old" => compact(
					"username",
					"remember"
				),
			]);
		}else{
			$this->flash->success("Successful login as {$username}");
			return $this->redirectHome($newResponse);
		}
	}

	/**
	 * POST /auth/login
	 *
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function register(Request $request, Response $response){
		$data = $request->getParsedBody();
		$email = $data["email"] ?? "";
		$username = $data["username"] ?? "";
		$password = $data["password"] ?? "";
		$remember = $data["remember"] ?? false;
		$res = $this->responseUtils->upgrade($response);

		[$newResponse, $user] = $this->auth->register($res, $email, $username, $password, $remember)->asArray();

		if($user === null){
			$this->flash->failure("Failed to register $username");
		}else{
			$this->flash->success("Successfully registered $username");
		}


		return $this->redirectHome($newResponse, [
			"old" => compact(
				"email",
				"username",
				"remember"
			),
		]);
	}


	/**
	 * GET /auth/logout
	 *
	 * @param Response $response
	 * @return Response
	 */
	public function logout(Response $response){
		$res = $this->responseUtils->upgrade($response);
		$response = $this->auth->logout($res);
		return $this->redirectHome($response);
	}
}
