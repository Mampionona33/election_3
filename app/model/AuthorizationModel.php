<?php

namespace ModelNamespace;

use ModelNamespace\SQL\DataBaseManager;

class AuthorizationModel extends DataBaseManager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName("Authorization");
        $this->setIdKey("id_authorization");
        $this->setColumns("$this->id_key INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        id_groupe INT,
        id_role INT,
        FOREIGN KEY (id_groupe) REFERENCES Groupe(id_groupe),
        FOREIGN KEY (id_role) REFERENCES Role(id_role);");
    }

    public function getGroupeRoles(int $groupeId): mixed
    {
        $query = "SELECT slug FROM Role WHERE id_role IN (SELECT id_role FROM " . $this->tableName . " WHERE id_groupe = " . $groupeId . ")";
        $result = $this->executeQuery($query);
        return $result;
    }
}
