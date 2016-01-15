<?php
session_start();
require_once "./app/init.php";
require_once "./vendor/autoload.php";
require_once "./app/autoloader.php";
require_once "app/Core/Framework/Logger.php";
require_once "app/Core/Framework/Router.php";
require_once "app/classes/SessionManager.php";

$controllerName = "Default";
if(array_key_exists('c', $_GET) && $_GET['c']) {
    $controllerName = $_GET['c'];
}

$action = "default";
if(array_key_exists('a', $_GET) && $_GET['a']) {
    $action = $_GET['a'];
}

var_dump($_GET);

$pdo = null;
try {
    if(defined(DB_HOST)) {
        $pdo = new PDO(DB_HOST, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

} catch (Exception $e) {
    echo "<pre>Connection impossible ".$e->getMessage()."</pre>";
}


try {
    $logger = new \Framework\Logger(__DIR__."/logs/logs.txt");
    $router = new \Framework\Router($logger);
    echo  $router->renderAction($controllerName, $action);

} catch (Exception $e) {
    $logger->debug($e->getMessage());
    echo "<pre>".$e->getMessage()."</pre>";
    echo "<pre>".$e->getTraceAsString()."</pre>";
}