<?php

namespace ControllerNamespace\candidat;

use Doctrine\ORM\NoResultException;
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
    private function getFirstCandidatPercentage(): ?float
    {
        $this->setQuery('SELECT ROUND((nbVoix * 100) / (SELECT SUM(nbVoix) FROM Candidat)) AS percentage 
        FROM Candidat
        WHERE id_candidat = (SELECT MIN(id_candidat) FROM Candidat)');

        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('percentage', 'percentage');

        try {
            return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
        } catch (NoResultException $th) {
            return null;
        }
    }

    private function getFirstCandidatId(): ?int
    {
        $this->setQuery('SELECT id_candidat FROM Candidat WHERE id_candidat=(SELECT MIN(id_candidat) FROM Candidat)');
        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('id_candidat', 'id_candidat');

        try {
            return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
        } catch (NoResultException $th) {
            return null;
        }
    }

    private function getCandidatMaxPointId(): ?int
    {
        $this->setQuery('SELECT id_candidat FROM Candidat 
        WHERE nbVoix = (SELECT Max(nbVoix) FROM Candidat);');

        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('id_candidat', 'id_candidat');

        try {
            return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
        } catch (NoResultException $th) {
            return null;
        }
    }

    public function getFirstCandidatName(): ?string
    {
        $this->setQuery('SELECT name FROM Candidat WHERE id_candidat=(SELECT MIN(id_candidat) FROM Candidat)');
        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('name', 'name');
        $result = $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getOneOrNullResult();
        try {
            if ($result !== null) {
                return $result['name'];
            }
            return null;
        } catch (NoResultException) {
            return null;
        }
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
