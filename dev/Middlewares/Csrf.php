<?php
namespace App\Middlewares;

use App\Exceptions\CsrfTokenMismatch;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use App\Actions\Csrf as CsrfAction;
use Slim\Http\Response;

class Csrf extends Middleware {
	/**@var CsrfAction $csrf*/
	protected $csrf;

	protected const METHODS = ["POST", "PUT", "DELETE"];

	public function __construct(Container $container) {
		parent::__construct($container);
//		$this->csrf = new CsrfAction($container);
		$this->csrf = $container->get(CsrfAction::class);
	}

	public function process(ServerRequestInterface $rq, Response $res, callable $next): ResponseInterface{
		$this->csrf->ensureHasToken();
		$key = $this->csrf->formKey();

		if(in_array($rq->getMethod(), static::METHODS)){
			$params = $rq->getParsedBody();
			$submittedToken = isset($params[$key])
			? $params[$this->csrf->formKey()]
			: "";

			if(!$this->csrf->isValid($submittedToken))
				throw new CsrfTokenMismatch();
		}

		$this->container->view["csrf_key"] = $key;
		$this->container->view["csrf_token"] = $this->csrf->getToken();

		return $next($rq, $res);
	}
}