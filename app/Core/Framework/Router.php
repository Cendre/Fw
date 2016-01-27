<?php
/**
 * Created by PhpStorm.
 * User: haniel
 * Date: 17/01/16
 * Time: 11:43
 */

namespace Framework;


use Controller\AbstractController;

class Router {
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param String $controllerName
     * @return AbstractController
     * @throws \Exception
     */
    private function getController($controllerName)
    {
        $fileName = __DIR__."/../Controller/".$controllerName."Controller.php";
        if(!file_exists($fileName)) {
            throw new \Exception("Page inconnue ".$fileName, 404);
        }

        include_once $fileName;

        $controllerClassName = "Controller\\".$controllerName."Controller";

        /** @var AbstractController $controller */
        $twig = $this->getTwig();
        $controller = new $controllerClassName($twig, $this->logger);

        return $controller;
    }

    /**
     * @param $controllerName
     * @param $action
     * @return mixed
     * @throws \Exception
     */
    public function renderAction($controllerName, $action)
    {
        $controller = $this->getController($controllerName);
        $actionName = $action."Action";
        if(!method_exists($controller, $actionName)) {
            throw new \Exception(sprintf('action $1%s does not exists on Controller $2%s', $action, $controllerName));
        }

        return $controller->$actionName();
    }

    /**
     * @desc Singleton for twig environment
     * @return \Twig_Environment
     */
    private function getTwig() {

        if($this->twig instanceof \Twig_Environment) {
            return $this->twig;
        }

        $loader = new \Twig_Loader_Filesystem(TEMPLATE_DIR);
        $twig = new \Twig_Environment($loader);
        return $twig;
    }
}