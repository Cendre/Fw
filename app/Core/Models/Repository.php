<?php
abstract class Repository {


    /**
     * @var \PDO $db
     */
    public $db;

    /**
     * @var Logger
     */
    public $logger;

    private $dbPrefix = "qr_";
    public $entityName;
    public $idFieldName;


    public function find($id) {
        if(!$this->idFieldName) {
            throw new EntityException("Primary key field name not defined for entity ".$this->entityName, 1);
        }
        $entity = $this->getEntity();
        $fields = $this->getFields();

        $request = 'SELECT %1$s FROM %2$s WHERE %3$s = :idvalue LIMIT 1';
        $request = sprintf($request, implode(", ",$fields), strtolower($this->dbPrefix.$this->entityName), $this->idFieldName);
        $statement = $this->db->prepare($request);

        $statement->execute(array(
            ":idvalue" => $id
        ));

        if($statement->rowCount() > 1) {
            throw new EntityException('Request return more than 1 result, 1 is expected', 2);
        }

        if($statement->rowCount() == 0 ) {
            return null;
        }

        $user = $statement->fetch();
        foreach($fields as $field) {
            $entity->$field = $user[$field];
        }

        return $entity;
    }


    public function getEntity() {
        include __DIR__."/".$this->entityName.".php";

        return new $this->entityName();
    }

    private function getFields() {
        $properties = get_class_vars($this->entityName);
        $fields = array();
        foreach ($properties as $prop => $value) {
            $fields[] = $prop;
        }

        return $fields;
    }

    protected function getTableName() {
        return strtolower($this->dbPrefix.$this->entityName);
    }


    protected function getEntityByStatement(PDOStatement $statement) {
        $entity = $this->getEntity();
        $fields = $this->getFields();
        $data   = $statement->fetch();

        foreach($fields as $field) {
            $entity->$field = $data[$field];
        }

        return $entity;
    }
}