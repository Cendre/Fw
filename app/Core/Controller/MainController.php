<?php
namespace Controller;
use Framework\Logger;
use \PDO;
use Twig_Environment;

class MainController {
    /**
     * @var Twig_Environment $twig
     */
    protected $twig;

    /** @var PDO $pdo */
    protected $pdo;

    /** @var Logger $logger */
    protected $logger;
    /**
     * @param Logger $logger
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig, Logger $logger)
    {
        $this->twig = $twig;
        $this->logger = $logger;
    }


    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }

}