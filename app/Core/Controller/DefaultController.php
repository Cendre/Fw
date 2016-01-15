<?php
namespace Controller;

use TestSpace\Internet;

include_once __DIR__ . "/MainController.php";

class DefaultController extends MainController {

    public function defaultAction() {
        $this->logger->debug("test");
        $internet = new Internet();
        return $this->twig->render('index.twig.html');
    }

    public function testAction() {
        echo "ta mere";
    }
}