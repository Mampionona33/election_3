<?php

namespace ModelNamespace;

use ModelNamespace\SQL\DataBaseManager;

class UserModel extends DataBaseManager
{
    public function __construct()
    {
        parent::__construct();
        $this->setIdKey("id_user");
        $this->setTableName("User");
        $this->setColumns("$this->id_key INT PRIMARY KEY AUTO_INCREMENT,email VARCHAR(255), password VARCHAR(255), id_groupe INT");
        $this->createTable($this->tableName, $this->columns);
    }

    public function getByEmail($user)
    {
        $query = "SELECT * FROM $this->tableName WHERE email = '{$user["email"]}' AND password= '{$user["password"]}'";
        return $this->executeQuery($query);
    }

    public function getRoles($user): array
    {
        $query = "SELECT id_role FROM Authorisation WHERE id_groupe = {$user['id_groupe']}";
        return $this->executeQuery($query);
    }
}
