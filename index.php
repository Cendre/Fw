<?php
session_start();
require_once "./app/init.php";
require_once "./vendor/autoload.php";
require_once "./app/autoloader.php";
require_once "app/Core/Framework/Logger.php";
require_once "app/Core/Framework/Router.php";

$controllerName = "Default";
if(array_key_exists('c', $_GET) && $_GET['c']) {
    $controllerName = $_GET['c'];
}

$action = "default";
if(array_key_exists('a', $_GET) && $_GET['a']) {
    $action = $_GET['a'];
}

try {
    $logger = new \Framework\Logger(__DIR__."/logs/logs.txt", \Framework\Logger::LOG_LEVEL_DEBUG);
    $router = new \Framework\Router($logger);
    echo $router->renderAction($controllerName, $action);
} catch (Exception $e) {
    $logger->alert($e->getMessage());
    echo "<pre>".$e->getMessage()."</pre>";
    echo "<pre>".$e->getTraceAsString()."</pre>";
}