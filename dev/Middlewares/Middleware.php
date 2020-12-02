<?php

namespace App\Middlewares;


use App\Actions\Response as ResponseUpgrader;
use App\Config\Config;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SlimSession\Helper as Session;

abstract class Middleware implements MiddlewareInterface
{
	/**@var ContainerInterface $container*/
	protected $container;

	/**
	 * @var ResponseUpgrader $responseUtils
	 */
	protected $responseUtils;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * @var Session
	 */
	protected $session;

	public function __invoke(Request $req, RequestHandlerInterface $handler): ResponseInterface
	{
		return $this->process($req, $handler);
	}

	public abstract function process(Request $req, RequestHandlerInterface $handler): ResponseInterface;

	public static function from(...$args)
	{
		return new static(...$args);
	}

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->responseUtils = $container->get(ResponseUpgrader::class);

		$this->config = $container->get(Config::class);
		$this->settings = $container->get("settings");
		$this->session = $container->get(Session::class);
	}
}
