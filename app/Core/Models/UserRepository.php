<?php

class UserRepository extends Repository {

    private $login;
    public $idFieldName = "id";

    /**
     * @param $login
     * @param $password
     * @return User|null
     */
    public function existingUser($login, $password) {
        $md5 = strtolower(md5($password));

        $request = 'SELECT id, login FROM %1$s WHERE login = :login AND password = :password';

        $request = sprintf($request, $this->getTableName());

        $statement = $this->db->prepare($request);

        $statement->execute(array(
            "login" => $login,
            "password" => $md5
        ));
        
        if($statement->rowCount() === 1) {
            $user = $this->getEntityByStatement($statement);
            return $user;
        } else {
            return null;
        }
    }
}