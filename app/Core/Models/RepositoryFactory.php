<?php

include_once __DIR__ . "/Repository.php";
include_once __DIR__ . "/EntityException.php";

class RepositoryFactory {

    /**
     * @var PDO
     */
    private $db;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(\PDO $db, Logger $logger) {
        $this->logger = $logger;
        $this->db = $db;
        $this->path = __DIR__;
    }

    /**
     * @param $entityName
     * @return Repository
     */
    public function getRepository($entityName) {
        $repositoryClass = $entityName."Repository";

        $fileName = __DIR__."/".$repositoryClass.".php";
        if(!file_exists($fileName)) {
            throw new EntityException("Entity ".$entityName." not found",3);
        }
        include_once($fileName);

        /** @var Repository $repository */
        $repository = new $repositoryClass();
        $repository->db = $this->db;
        $repository->logger = $this->logger;
        $repository->entityName = $entityName;

        return $repository;
    }
}