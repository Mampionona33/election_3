<?php

namespace ControllerNamespace\page;

use ControllerNamespace\candidat\CandidatBase;
use ControllerNamespace\candidat\CandidatController;
use ControllerNamespace\candidat\CreateTableCandidat;
use ControllerNamespace\candidat\FirstCandidat;
use ControllerNamespace\FirstCandidatResult;
use Entity\Candidat;
use Lib\AppEntityManage;

class HomePageController extends BasePage
{
    private CreateTableCandidat $createTableCandidat;
    private AppEntityManage $appEntityManage;
    private FirstCandidatResult $firstCandidatResult;

    /**
     * Setter
     */
    public function setFirstCandidatResult(FirstCandidatResult $firstCandidatResult): void
    {
        $this->firstCandidatResult = $firstCandidatResult;
    }
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }

    public function setCreateTableCandidat(CreateTableCandidat $createTableCandidat): void
    {
        $this->createTableCandidat = $createTableCandidat;
    }


    /**
     * Getter
     */
    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManage;
    }
    public function getCreateTableCandidat(): CreateTableCandidat
    {
        return $this->createTableCandidat;
    }


    // private function  getFirstCandidatFromDB(): array
    // {
    //     $dql = 'SELECT c FROM Entity\Candidat c WHERE c.id = (SELECT MIN(c2.id) FROM Entity\Candidat c2)';
    //     $query = $this->appEntityManage->getEntityManager()->createQuery($dql);
    //     return $query->getResult();
    // }

    // private function getCandidatWhichHasMaxPointFromDb(): array
    // {
    //     $dql = 'SELECT c FROM Entity\Candidat c WHERE c.nb_voix = (SELECT MAX(c2.nb_voix) FROM Entity\Candidat c2)';
    //     $query = $this->appEntityManage->getEntityManager()->createQuery($dql);
    //     return $query->getResult();
    // }

    // private function getAllCandidatDataFromDB(): array
    // {
    //     return $this->appEntityManage->getEntityManager()->getRepository(Candidat::class)->findAll();
    // }



    public function __construct()
    {
        parent::__construct();
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setCreateTableCandidat(new CreateTableCandidat());
        $this->createTableCandidat->execute();
        $this->setFirstCandidatResult(new FirstCandidatResult());
    }

    public function render(): void
    {
        echo $this->getTwig()->render("homepage.html.twig", [
            "firstCandidatResult" => $this->firstCandidatResult->getResult(),
            "firstCandidatName" => $this->firstCandidatResult->getFirstCandidatName()
        ]);
    }
}
