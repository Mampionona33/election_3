<?php

namespace ControllerNamespace;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Entity\Candidat;
use Lib\AppEntityManage;

class FirstCandidatResult
{
    private AppEntityManage $appEntityManage;
    private string $query;
    private ResultSetMappingBuilder $resultSetMappingBuilder;
    /**
     * setter
     */
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

    private function  getFirstCandidatFromDB(): array
    {
        $this->setQuery('SELECT c FROM Entity\Candidat c WHERE c.id = (SELECT MIN(c2.id) FROM Entity\Candidat c2)');
        return $this->appEntityManage->getEntityManager()->createQuery($this->query)->getResult();
    }

    private function getCandidatWhichHasMaxPointFromDb(): array
    {
        $this->setQuery('SELECT c FROM Entity\Candidat c WHERE c.nb_voix = (SELECT MAX(c2.nb_voix) FROM Entity\Candidat c2)');
        return $this->appEntityManage->getEntityManager()->createQuery($this->query)->getResult();
    }

    private function getAllCandidatDataFromDB(): array
    {
        return $this->appEntityManage->getEntityManager()->getRepository(Candidat::class)->findAll();
    }

    private function getFirstCandidatPercentage(): float
    {
        $this->setQuery('SELECT ROUND((nb_voix * 100) / (SELECT SUM(nb_voix) FROM Candidat)) AS percentage 
        FROM Candidat
        WHERE id_candidat = (SELECT MIN(id_candidat) FROM Candidat)');

        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManage->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('percentage', 'percentage');

        return $this->appEntityManage->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
    }

    private function getCandidatMaxPointPercentage(): float
    {
        $this->setQuery('SELECT ROUND(nb_voix * 100 / (SELECT SUM(nb_voix) FROM Candidat)) AS percentage 
        FROM Candidat 
        WHERE nb_voix = (SELECT Max(nb_voix) FROM Candidat);');

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



    public function __construct()
    {
        $this->setAppEntityManage(AppEntityManage::getInstance());
        var_dump($this->getCandidatMaxPointId());
        var_dump($this->getCandidatMaxPointPercentage());
        var_dump($this->getFirstCandidatId());
        var_dump($this->getFirstCandidatPercentage());
    }
}
