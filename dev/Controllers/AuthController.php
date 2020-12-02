<?php


namespace App\Controllers;

use App\Actions\Auth;
use App\Exceptions\CannotRegisterUser;
use App\Exceptions\InvalidLoginAttempt;
use App\Exceptions\UserDoesNotExist;
use App\Models\User;
use App\Requests\Auth\LoginRequest;
use App\Requests\Auth\RegisterRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends Controller
{
	/**
	 * @var Auth
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
	 * @param LoginRequest $form
	 * @param Response $response
	 * @return Response
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function login(LoginRequest $form, Response $response){
		$data = $form->validatedData();
		$username = $data["username"];
		$password = $data["password"];
		$remember = $data["remember"];

		$res = $this->responseUtils->upgrade($response);

		try{
			$newResponse = $this->auth->login(
				$res,
				$username,
				$password,
				$remember
			)->response;

			$this->flash->success("Successful login as {$username}");
			return $this->redirectHome($newResponse);
		}catch(UserDoesNotExist $e){
			$this->flash->failure("This user does not exist");
		}catch(InvalidLoginAttempt $e){
			$this->flash->failure("Invalid password");
		}

		return $this->responseUtils->redirectToRoute($res, "auth.login", [
			"old" => compact(
				"username",
				"remember"
			),
		]);
	}

	/**
	 * POST /auth/login
	 *
	 * @param Request $form
	 * @param Response $response
	 * @return Response
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 * @throws UserDoesNotExist
	 * @throws InvalidLoginAttempt
	 */
	public function register(RegisterRequest $form, Response $response){
		$data = $form->validatedData();
		$email = $data["email"];
		$username = $data["username"];
		$password = $data["password"];
		$remember = $data["remember"];
		$res = $this->responseUtils->upgrade($response);

		try {
			$res = $this->auth->register($res, $email, $username, $password, $remember)->response;
			$this->flash->success("Successfully registered $username");
		}catch (CannotRegisterUser $e){
			$this->flash->failure("Failed to register $username");
		}


		return $this->redirectHome($res, [
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
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function logout(Response $response){
		$res = $this->responseUtils->upgrade($response);
		$response = $this->auth->logout($res);
		return $this->redirectHome($response);
	}
}
