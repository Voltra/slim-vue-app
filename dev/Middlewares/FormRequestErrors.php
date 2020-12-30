<?php


namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

class FormRequestErrors extends Middleware
{

	/**
	 * @param Request $req
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
    public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
    {
    	$errorsKey = "errors";

    	if($this->session->exists($errorsKey)){
			/**
			 * @var Twig $view
			 */
			$view = resolve(Twig::class);
    		$errors = $this->session->get($errorsKey);
			$view->getEnvironment()->addGlobal($errorsKey, $errors);
		}

    	$res = $handler->handle($req);
    	$this->session->delete($errorsKey); // only display errors once
    	return $res;
    }
}
