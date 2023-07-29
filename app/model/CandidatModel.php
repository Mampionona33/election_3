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

    public function customGetAll(): array
    {
        $this->setQuery("SELECT id_candidat, name, nb_voix AS voix, CONCAT( ROUND((nb_voix * 100 / (SELECT SUM(nb_voix) FROM $this->tableName)), 2) ) AS pourcentage FROM $this->tableName;");
        return $this->executeQuery($this->getQuery());
    }

    public function getAllWithPercentage(): array
    {
        $this->setQuery("SELECT * FROM $this->tableName WHERE $this->id_key = (SELECT MIN($this->id_key) FROM Candidat);");
        return $this->executeQuery($this->getQuery());
    }

    public function getFirstCandidat(): array
    {
        $this->setQuery("SELECT * FROM Candidat WHERE id_candidat = (SELECT MIN(id_candidat)FROM Candidat);");
        return $this->executeQuery($this->getQuery());
    }

    public function getCandidatWithMaxPoint(): array
    {
        $this->setQuery("SELECT *, ROUND(nb_voix * 100 / (SELECT SUM(nb_voix) FROM $this->tableName)) AS percentage FROM $this->tableName WHERE nb_voix = (SELECT Max(nb_voix) FROM $this->tableName);");
        return $this->executeQuery($this->getQuery());
    }
}
