<?php
namespace Controller;



class DefaultController extends AbstractController {

    public function defaultAction() {
        return $this->twig->render('index.twig.html');
    }

    public function testAction() {
        phpinfo();
    }
}
