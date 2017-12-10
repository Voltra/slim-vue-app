<?php
require_once "../vendor/autoload.php";//Require Composer's autoload file

use App\Helpers\WhiteboxFeatures\RouteLoader;

function relativeUrl(string $path){
    return dirname(__FILE__) . DIRECTORY_SEPARATOR . $path;
}

///////////////////////////////////////////
//Configure the route loader generator
///////////////////////////////////////////
function generateRouteAutoloadFile(string $routesFolder, string $autoloadFileURI){
    /*Instantiate a new RouteLoader with the path to all the routes definition files*/
    $routeLoader = new RouteLoader(relativeUrl($routesFolder));

    /*Creates a loader file with the name "route_autoload.php" in the same directory as this class*/
    $loaderURI = relativeUrl($autoloadFileURI);
    $routeLoader->generateLoaderFile($loaderURI);
}


//Call it
generateRouteAutoloadFile("routes", "route_autoload.php");