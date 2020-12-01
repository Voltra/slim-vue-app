<?php


namespace App\Handlers;


use App\Config\Config;
use App\Helpers\AppEnv;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;

//cf. https://www.slimframework.com/docs/v4/objects/application.html#advanced-custom-error-handler

class UnhandledExceptionHandler extends ErrorHandler
{
	/**
	 * @var Twig
	 */
	protected $view;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var array
	 */
	protected $settings;

	public function __construct(CallableResolverInterface $callableResolver, ResponseFactoryInterface $responseFactory, ?LoggerInterface $logger = null)
	{
		parent::__construct($callableResolver, $responseFactory, $logger);
		$this->view = resolve(Twig::class);
		$this->config = resolve(Config::class);
		$this->settings = $this->config->get("errors");
	}

	protected function render(int $status, \Throwable $e){
		$res = new Response($status);
		try {
			return $this->view->render($res, "errors/$status.twig", [
				"exception" => $e,
			]);
		} catch (\Throwable $e) {
			$res->getBody()->write("Error $status");
			return $res;
		}
	}

	protected function respond(): ResponseInterface{
		$e = $this->exception;

		if(AppEnv::dev() && $this->settings["delegate"]){
			// Delegate to other middlewares in dev
			throw $e;
		}

		if($e instanceof HttpBadRequestException){
			return $this->render(400, $e);
		}else if($e instanceof HttpUnauthorizedException){
			return $this->render(401, $e);
		}else if($e instanceof HttpForbiddenException){
			return $this->render(403, $e);
		}else if($e instanceof HttpNotFoundException){
			return $this->render(404, $e);
		}else{ // HttpInternalServerErrorException and others
			return $this->render(500, $e);
		}
	}
}
