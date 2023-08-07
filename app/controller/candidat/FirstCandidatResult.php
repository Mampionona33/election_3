<?php

namespace ControllerNamespace\candidat;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Entity\Candidat;
use Lib\AppEntityManage;

class FirstCandidatResult
{
    private AppEntityManage $appEntityManage;
    private string $query;
    private ResultSetMappingBuilder $resultSetMappingBuilder;
    private string $result;
    /**
     * setter
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }
    public function setResultSetMappingBuilder(ResultSetMappingBuilder $resultSetMappingBuilder): void
    {
        $this->resultSetMappingBuilder = $resultSetMappingBuilder;
    }
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }
    /**
     * Getter
     */
    public function getResult(): string
    {
        return $this->result;
    }
    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManage;
    }
    public function getQuery(): string
    {
        return $this->query;
    }
    public function getResultSetMappingBuilder(): ResultSetMappingBuilder
    {
        return $this->resultSetMappingBuilder;
    }

    // ---------------------------------------
    private function getFirstCandidatPercentage(): float
    {
        $this->setQuery('SELECT ROUND((nb_voix * 100) / (SELECT SUM(nb_voix) FROM Candidat)) AS percentage 
        FROM Candidat
        WHERE id_candidat = (SELECT MIN(id_candidat) FROM Candidat)');

        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('percentage', 'percentage');

        return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
    }

    private function getFirstCandidatId(): int
    {
        $this->setQuery('SELECT id_candidat FROM Candidat WHERE id_candidat=(SELECT MIN(id_candidat) FROM Candidat)');
        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('id_candidat', 'id_candidat');
        return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
    }

    private function getCandidatMaxPointId(): int
    {
        $this->setQuery('SELECT id_candidat FROM Candidat 
        WHERE nb_voix = (SELECT Max(nb_voix) FROM Candidat);');

        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('id_candidat', 'id_candidat');

        return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
    }

    public function getFirstCandidatName(): ?string
    {
        $this->setQuery('SELECT name FROM Candidat WHERE id_candidat=(SELECT MIN(id_candidat) FROM Candidat)');
        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('name', 'name');
        return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getOneOrNullResult()['name'];
    }

    private function generateResult(): void
    {
        if ($this->getFirstCandidatId() !== $this->getCandidatMaxPointId()) {
            if ($this->getFirstCandidatPercentage() >= 12.5) {
                $this->setResult("Le candidat " . $this->getFirstCandidatName() . " participe au deuxième tour en ballotage défavorable avec un suffrage de " . $this->getFirstCandidatPercentage() . " % ");
            } else {
                $this->setResult("Le candidat " . $this->getFirstCandidatName() . " est battu à la première tour avec un suffrage de " . $this->getFirstCandidatPercentage() . " %.");
            }
        } else {
            if ($this->getFirstCandidatPercentage() >= 50) {
                $this->setResult($this->getFirstCandidatName() . " est élu à la première tour avec un suffrage de " . $this->getFirstCandidatPercentage() . " %.");
            } else {
                $this->setResult("Le candidat " . $this->getFirstCandidatName() . " participe au deuxième tour en ballotage favorable avec un suffrage de " . $this->getFirstCandidatPercentage() . " %.");
            }
        }
    }

    public function __construct()
    {
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->generateResult();
    }
}
