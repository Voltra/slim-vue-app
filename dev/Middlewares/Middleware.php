<?php

namespace App\Middlewares;


use App\Actions\Response as ResponseUpgrader;
use App\Config\Config;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Middleware implements MiddlewareInterface
{
	/**@var ContainerInterface $container*/
	protected $container;

	/**
	 * @var ResponseUpgrader $responseUpgrader
	 */
	protected $responseUpgrader;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var array $settings
	 */
	protected $settings;

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
		$this->responseUpgrader = $container->get(ResponseUpgrader::class);

		$this->config = $container->get(Config::class);
		$this->settings = $container->get("settings");
	}
}
