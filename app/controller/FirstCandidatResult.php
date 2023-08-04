<?php

namespace ControllerNamespace;

use Lib\AppEntityManage;

class FirstCandidatResult
{
    private AppEntityManage $appEntityManage;
    /**
     * setter
     */
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

    private function  getFirstCandidatFromDB(): array
    {
        $dql = 'SELECT c FROM Entity\Candidat c WHERE c.id = (SELECT MIN(c2.id) FROM Entity\Candidat c2)';
        $query = $this->appEntityManage->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    private function getCandidatWhichHasMaxPointFromDb(): array
    {
        $dql = 'SELECT c FROM Entity\Candidat c WHERE c.nb_voix = (SELECT MAX(c2.nb_voix) FROM Entity\Candidat c2)';
        $query = $this->appEntityManage->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    private function getAllCandidatDataFromDB(): array
    {
        return $this->appEntityManage->getEntityManager()->getRepository(Candidat::class)->findAll();
    }


    public function __construct()
    {
        $this->setAppEntityManage(AppEntityManage::getInstance());
        var_dump($this->getCandidatWhichHasMaxPointFromDb());
    }
}
