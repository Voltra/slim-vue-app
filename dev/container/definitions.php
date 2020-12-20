<?php

use App\Config\Config;
use App\Helpers\AppEnv;
use App\Helpers\Path;
use App\Helpers\TwigExtensions\AuthExtension;
use App\Helpers\TwigExtensions\CsrfExtension;
use App\Helpers\TwigExtensions\FlashExtension;
use App\Helpers\TwigExtensions\MjmlExtension;
use App\Helpers\TwigExtensions\PathExtension;
use DI\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Env;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Interfaces\RouteInterface;
use Slim\Routing\Route;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;
use SlimSession\Helper as Session;
use Slim\Flash\Messages as FlashMessages;

/**
 * @param string[] $classes
 * @returns array<string, \DI\Definition\Helper\AutowireDefinitionHelper>
 * @return array
 */
function autowired(array $classes): array{
	return array_reduce(array_map(static function ($class) {
		return [$class => \DI\autowire($class)];
	}, $classes), "array_merge", []);
}

/**
 * @param string|null $class
 * @param mixed ...$args
 * @return \DI\Definition\Helper\CreateDefinitionHelper
 */
function construct(?string $class = null, ...$args){
	return \DI\create($class)->constructor(...$args);
}

/******************************************************************************************************************\
 * Via keys
\******************************************************************************************************************/
$viaKeys = [
	"config" => \DI\value(require(Path::dev("/config.php"))),
	"settings" => static function(Container $container){
		/**
		 * @var Config $config
		 */
		$config = $container->get("config");
		return $config->get("settings");
	},
	"logger" => static function (Container $container) {
		$config = $container->get("config");
		$settings = $config["logs"];

		$logger = new Logger($settings["name"]);
		$logger->pushHandler(new StreamHandler(
			Path::root($settings["path"]),
			$settings["level"])
		);

		return $logger;
	},
	"session" => static function (Container $container){
		return new Session();
	},
	"flash" => static function(Container $container){
		session_start();
		return new FlashMessages();
	},
	"view" => static function(Container $container){
		$config = $container->get("config");
		$view = Twig::create(
			Path::dev("/views"),
			$config["views"]
		);

		$flash = $container->get("flash");

		$view->addExtension(resolve(MjmlExtension::class));
		$view->addExtension(new FlashExtension($flash));
		$view->addExtension(new CsrfExtension($container));
		$view->addExtension(new PathExtension($container));
		$view->addExtension(new AuthExtension($container));
		if(AppEnv::dev())
			$view->addExtension(new \Twig\Extension\DebugExtension());

		return $view;
	},
	"manifest" => static function(Container $container){
		$fs = $container->get(Filesystem::class);
		$rawJson = $fs->get(Path::assets("/manifest.json"));
		return json_decode($rawJson, true);
	},
	"router" => static function(Container $container){
		$app = $container->get(\Slim\App::class);
		return $app->getRouteCollector()->getRouteParser();
	},
	"request" => static function(Container $container){
		return ServerRequestCreatorFactory::create()
			->createServerRequestFromGlobals();
	},
	"app" => \DI\get(\Slim\App::class),
	"routeParser" => static function(Container $container){
//		return $container->get("routeContext")->getRouteParser();
		return $container->get("app")
			->getRouteCollector()
			->getRouteParser();
	},
	"routeContext" => static function(Container $container){
		return RouteContext::fromRequest($container->get("request"));
	},
	"route" => static function(Container $container){
		return $container->get("routeContext")->getRoute();
	},
];

/******************************************************************************************************************\
 * Via class strings
\******************************************************************************************************************/
$viaClassStrings = [
	ContainerInterface::class => static function(Container $container){ return $container; },
	Session::class => \DI\get("session"),
	LoggerInterface::class => \DI\get("logger"),
	Twig::class => \DI\get("view"),
	Config::class => \DI\get("config"),
	ServerRequestInterface::class => \DI\get("request"),
	RouteParser::class => \DI\get("routeParser"),
	RouteContext::class => \DI\get("routeContext"),
	RouteInterface::class => \DI\get("route"),
	Route::class => \DI\get("route"),
	\League\Flysystem\Adapter\Local::class => static function(Container $container){
		return new \League\Flysystem\Adapter\Local(Path::uploads());
	},
	\Illuminate\Events\Dispatcher::class => construct(\Illuminate\Events\Dispatcher::class),
	\Qferrer\Mjml\Renderer\BinaryRenderer::class => static function(Container $container){
		/**
		 * @var Config $config
		 */
		$config = $container->get("config");
		return new \Qferrer\Mjml\Renderer\BinaryRenderer($config["mail.mjml_exe"]);
	},
	\Qferrer\Mjml\Renderer\RendererInterface::class => \DI\get(\Qferrer\Mjml\Renderer\BinaryRenderer::class),
	\Symfony\Component\Mailer\Transport::class => static function(Container $container){
		/**
		 * @var Config $config
		 */
		$config = $container->get("config");
		$mail = $config["mail"];

		[
			$type,
			$username,
			$password,
			$host,
			$port,
		] = [
			$mail["type"],
			$mail["username"],
			$mail["password"],
			$mail["host"],
			$mail["port"],
		];

		$dsn = "{$type}://{$username}:{$password}@{$host}:{$port}";
		return \Symfony\Component\Mailer\Transport::fromDsn($dsn);
	},
	\Symfony\Component\Mailer\Transport\TransportInterface::class => \DI\get(\Symfony\Component\Mailer\Transport::class),
	\Symfony\Component\Mailer\Mailer::class => static function(Container $container){
		return new \Symfony\Component\Mailer\Mailer($container->get(\Symfony\Component\Mailer\Transport\TransportInterface::class));
	},
	\Symfony\Component\Mailer\MailerInterface::class => \DI\get(\Symfony\Component\Mailer\Mailer::class),
	\Symfony\Bridge\Twig\Mime\BodyRenderer::class => static function(Container $container){
		/**
		 * @var Twig
		 */
		$view = $container->get(Twig::class);
		return new \Symfony\Bridge\Twig\Mime\BodyRenderer($view->getEnvironment());
	},
	\Symfony\Component\Mime\BodyRendererInterface::class => \DI\get(\Symfony\Bridge\Twig\Mime\BodyRenderer::class),
	\App\Handlers\UniformErrorHandler::class => require("errors.php"),
];



/******************************************************************************************************************\
 * Actions
\******************************************************************************************************************/
$actions = autowired([
	\App\Actions\Response::class,
	\App\Actions\Hash::class,
	\App\Actions\Random::class,
	\App\Actions\Flash::class,
	\App\Actions\Cookies::class,
	\App\Actions\Csrf::class,
	\App\Actions\Auth::class,
	\App\Actions\TwoFactor::class,
	\App\Actions\FileSystem::class,
	\App\Actions\Validator::class,
]);



/******************************************************************************************************************\
 * Filters
\******************************************************************************************************************/
$filters = autowired([
	\App\Filters\VisitorFilter::class,
	\App\Filters\UserFilter::class,
	\App\Filters\LogoutFilter::class,
	\App\Filters\AdminFilter::class,
]);



/******************************************************************************************************************\
 * Utils
\******************************************************************************************************************/
$utils = autowired([
	Filesystem::class,
]);



return $viaKeys + $viaClassStrings + $actions + $filters + $utils;
