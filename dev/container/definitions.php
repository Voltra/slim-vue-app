<?php

use App\Config\Config;
use App\Helpers\Path;
use App\Helpers\TwigExtensions\CsrfExtension;
use App\Helpers\TwigExtensions\FlashExtension;
use App\Helpers\TwigExtensions\PathExtension;
use DI\Container;
use Illuminate\Support\Env;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
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

return [
	/******************************************************************************************************************\
	 * Via keys
	\******************************************************************************************************************/
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

		$view->addExtension(new FlashExtension($flash));
		$view->addExtension(new CsrfExtension($container));
		$view->addExtension(new PathExtension($container));
		if(Env::get("PHP_ENV", "production") === "development")
			$view->addExtension(new \Twig\Extension\DebugExtension());

		return $view;
	},
	"manifest" => static function(Container $container){
		$fs = $container->get(\Illuminate\Filesystem\Filesystem::class);
		$rawJson = $fs->get(Path::assets("/manifest.json"));
		return json_decode($rawJson, true);
	},
	"router" => static function(Container $container){
		$app = $container->get(\Slim\App::class);
		return $app->getRouteCollector()->getRouteParser();
	},



	/******************************************************************************************************************\
	 * Via class strings
	\******************************************************************************************************************/
	\Psr\Container\ContainerInterface::class => static function(Container $container){
		return $container;
	},
	\Psr\Log\LoggerInterface::class => \DI\get("logger"),
	Twig::class => \DI\get("view"),
	Config::class => \DI\get("config"),
] + autowired([
	/******************************************************************************************************************\
	 * Actions
	\******************************************************************************************************************/
	\App\Actions\PostValidator::class,
	\App\Actions\Response::class,
	\App\Actions\Hash::class,
	\App\Actions\Random::class,
	\App\Actions\Flash::class,
	\App\Actions\Cookies::class,
	\App\Actions\Csrf::class,
	\App\Actions\Auth::class,



	/******************************************************************************************************************\
	 * Filters
	\******************************************************************************************************************/
	\App\Filters\VisitorFilter::class,
	\App\Filters\UserFilter::class,
	\App\Filters\LogoutFilter::class,
	\App\Filters\AdminFilter::class,



	/******************************************************************************************************************\
	 * Utils
	\******************************************************************************************************************/
	\Illuminate\Filesystem\Filesystem::class
]);
