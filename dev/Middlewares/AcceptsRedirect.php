<?php


namespace App\Middlewares;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class AcceptsRedirect extends Middleware
{
	/**
	 * @var mixed
	 */
	protected $attr;

	public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
		$this->attr = $this->config["redirect.attribute"];
	}

	public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
    {
    	$request = $req->withAttribute($this->attr, true);
    	return $handler->handle($req);
    }
}
