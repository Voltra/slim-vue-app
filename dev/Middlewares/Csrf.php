<?php

namespace App\Middlewares;

use App\Exceptions\CsrfTokenMismatch;
use Psr\Http\Message\ResponseInterface;
use DI\Container;
use App\Actions\Csrf as CsrfAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class Csrf extends Middleware
{
	/**@var CsrfAction $csrf*/
	protected $csrf;

	protected const METHODS = ["POST", "PUT", "DELETE"];

	public function __construct(Container $container)
	{
		parent::__construct($container);
		$this->csrf = $container->get(CsrfAction::class);
	}

	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		$this->csrf->ensureHasToken();
		$key = $this->csrf->formKey();

		if (in_array($req->getMethod(), static::METHODS)) {
			$params = $req->getParsedBody();
			$submittedToken = $params[$key] ?? "";

			if (!$this->csrf->isValid($submittedToken))
				throw new CsrfTokenMismatch();
		}

		$view = $this->container->get("view");
		$view["csrf_key"] = $key;
		$view["csrf_token"] = $this->csrf->getToken();

		$rawResponse = $handler->handle($req);
		return $this->responseUpgrader->upgrade($rawResponse);
	}
}
