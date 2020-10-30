<?php


namespace App\Middlewares;


use App\Actions\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectAfterRequest extends Middleware
{
	const MODES = [
		"qs",
		"body",
	];

	/**
	 * @var string
	 */
	protected $mode;
	/**
	 * @var string
	 */
	protected $key;
	/**
	 * @var string
	 */
	protected $attr;

	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
		$this->mode = $this->config["redirect.mode"];
		$this->key = $this->config["redirect.key"];
		$this->attr = $this->config["redirect.attribute"];
		$this->responseUtils = $container->get(Response::class);

		if(!in_array($this->mode, self::MODES))
			throw new \InvalidArgumentException("Invalid mode for Redirectable");
	}

	public function shouldRedirect(Request $req): bool{
		return !!$req->getAttribute($this->attr);
	}

	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
    {
    	$url = null;

    	try{
			if($this->mode === "qs")
				$url = $this->processQueryString($req, $handler);
			else if($this->mode === "body")
				$url =  $this->processBody($req, $handler);
		}catch(\Throwable $e){}

    	$res = $handler->handle($req);
    	return $url !== null ? $this->responseUtils->redirect($res, $url) : $res;
    }

	protected function processQueryString(Request $req, RequestHandlerInterface $handler)
	{
		return $req->getQueryParams()[$this->key];
		//TODO: Make sure it's a valid URL?
		/*$res = $handler->handle($req);
		return $this->responseUtils->redirect($res, $url);*/
	}

	protected function processBody(Request $req, RequestHandlerInterface $handler)
	{
		return $req->getParsedBody()[$this->key];
		//TODO: Make sure it's a valid URL?
		/*$res = $handler->handle($req);
		return $this->responseUtils->redirect($res, $url);*/
	}
}
