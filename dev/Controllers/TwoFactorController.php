<?php


namespace App\Controllers;


use App\Actions\TwoFactor;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TwoFactorController extends Controller
{
	/**
	 * GET /2fa/{user}
	 * @param Request $request
	 * @param Response $response
	 * @param User $user
	 * @param TwoFactor $tfa
	 * @return Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @throws \RobThree\Auth\TwoFactorAuthException
	 */
	public function twoFactor(Request $request, Response $response, User $user, TwoFactor $tfa){
		$qrcode = $tfa->qrCode($user);
		$secret = $tfa->secret($user);

		return $this->view->render($response, "2fa.twig", compact(
			"user",
			"qrcode",
			"secret"
		));
	}

	/**
	 * GET /2fa/enable/{user}
	 * @param Response $response
	 * @param User $user
	 * @param TwoFactor $tfa
	 * @return Response
	 */
	public function enable2FA(Response $response, User $user, TwoFactor $tfa){
		$tfa->enable2FA($user);
		return $this->responseUtils->redirectToRoute($response, "demo.2fa", [
			"__user" => $user->username,
		]);
	}

	/**
	 * GET /2fa/disable/{user}
	 * @param Response $response
	 * @param User $user
	 * @param TwoFactor $tfa
	 * @return Response
	 */
	public function disable2FA(Response $response, User $user, TwoFactor $tfa){
		$tfa->disable2FA($user);
		return $this->responseUtils->redirectToRoute($response, "demo.2fa", [
			"__user" => $user->username,
		]);
	}
}
