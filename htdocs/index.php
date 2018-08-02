<?php
/**
 * Bootstrap the framework and handle the request.
 */

// Were are all the files?
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));
//define("ANAX_APP_PATH", ANAX_INSTALL_PATH);

// Set the basis for error handling
require ANAX_INSTALL_PATH . "/config/error_reporting.php";

// Get the autoloader by using composers version.
require ANAX_INSTALL_PATH . "/vendor/autoload.php";

// Add all services to $di
$di = new \Anax\DI\DIFactoryConfig("di.php");

// Enable to also use $app style to access services, disable $app by comment
// the lines below.
$app = new \Anax\App\AppDIMagic();
$di->setShared("app", $app);
$app->setDI($di);

// Include user defined routes using $app-style.
foreach (glob(__DIR__ . "/../route/*.php") as $filename) {
    require $filename;
}

// Leave to router to match incoming request to routes
$di->get("router")->handle(
    $di->get("request")->getRoute(),
    $di->get("request")->getMethod()
);
