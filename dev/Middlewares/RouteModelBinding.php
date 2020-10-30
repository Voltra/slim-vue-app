<?php


namespace App\Middlewares;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

//cf. https://fetzi.dev/implicit-model-binding-in-slim-apis/

class RouteModelBinding extends Middleware
{
	/**
	 * @inheritDoc
	 * @throws HttpNotFoundException
	 */
    public function process(Request $req, RequestHandlerInterface $handler): ResponseInterface
    {
		$routeContext = RouteContext::fromRequest($req);
		$route = $routeContext->getRoute();

		if(is_null($route))
			throw new HttpNotFoundException($req);

		$parameterMapping = $this->config->get("viewModelBinding", []);
		collect($parameterMapping)
			->lazy()
			->filter(function ($mapping, $parameter) use($route){
				return !is_null($route->getArgument($parameter));
			})->each(function($mapping, $parameter) use($route, $req){
				$discriminantValue = $route->getArgument($parameter);
				$modelClass = $mapping["model"];
				$discriminantKey = $mapping["column"];

				/**
				 * @var Model|null $model
				 */
				$model = $modelClass::firstWhere($discriminantKey, $discriminantValue);
				if(is_null($model))
					throw new HttpNotFoundException($req);

				$route->setArgument($parameter, $model); //TODO: Fix the fact that it converts to string
				$this->container->set($modelClass, $model); //WARNING: Dangerous fix w/ PHP-DI

				$route->setArgument("{$parameter}Discriminant", $discriminantValue);
				$route->setArgument("{$parameter}Id", $model->id);
			})->toArray();

		return $handler->handle($req);
    }
}
