<?php

namespace ModelNamespace;

use ModelNamespace\SQL\DataBaseManager;

class CandidatModel extends DataBaseManager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName("Candidat");
        $this->setIdKey("id_candidat");
        $this->setColumns("$this->id_key INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        nb_voix INT");
        $this->createTable($this->tableName, $this->columns);
    }

    public function getResult(): array
    {
        $query = "SELECT * FROM $this->tableName WHERE $this->id_key = (SELECT MIN($this->id_key) FROM Candidat);";
        return $this->executeQuery($query);
    }
}
