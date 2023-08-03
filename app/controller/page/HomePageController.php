<?php

namespace ControllerNamespace\page;

use ControllerNamespace\candidat\CreateTableCandidat;
use Entity\Candidat;
use Lib\AppEntityManage;

class HomePageController extends BasePage
{
    private array $listCandidat;
    private CreateTableCandidat $createTableCandidat;
    private AppEntityManage $appEntityManage;
    private array $firstCandidat;
    private array $candidatWhichHasMaximumPoint;
    private int $firstCandidatPercentagePoint;
    private array $allCandidatData;
    /**
     * Setter
     */
    public function setAllCandidatData(array $allCandidatData): void
    {
        $this->allCandidatData = $allCandidatData;
    }
    public function setFirstCandidatPercentagePoint(int $firstCandidatPercentagePoint): void
    {
        $this->firstCandidatPercentagePoint = $firstCandidatPercentagePoint;
    }
    public function setCandidatWhichHasMaximumPoint(array $candidatWhichHasMaximumPoint): void
    {
        $this->candidatWhichHasMaximumPoint = $candidatWhichHasMaximumPoint;
    }
    public function setFirstCandidat($firstCandidat): void
    {
        $this->firstCandidat = $firstCandidat;
    }
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }

    public function setCreateTableCandidat(CreateTableCandidat $createTableCandidat): void
    {
        $this->createTableCandidat = $createTableCandidat;
    }
    public function setListCandidat(array $listCandidat): void
    {
        $this->listCandidat = $listCandidat;
    }
    public function getFirstCandidat()
    {
        return $this->firstCandidat;
    }

    /**
     * Getter
     */
    public function getAllCandidatData(): array
    {
        return $this->allCandidatData;
    }
    public function getFirstCandidatPercentagePoint(): int
    {
        return $this->firstCandidatPercentagePoint;
    }
    public function getCandidatWhichHasMaximumPoint(): array
    {
        return $this->candidatWhichHasMaximumPoint;
    }
    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManage;
    }
    public function getCreateTableCandidat(): CreateTableCandidat
    {
        return $this->createTableCandidat;
    }
    public function getListCandidat(): array
    {
        return $this->listCandidat;
    }

    private function initializeFirstCandidat(): void
    {
        $this->setFirstCandidat($this->getFirstCandidatFromDB());
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

    public function initializeAllCandidatData(): void
    {
        $this->setAllCandidatData($this->getAllCandidatDataFromDB());
    }

    public function initializeCandidatWhichHasMaxPoint(): void
    {
        $this->setCandidatWhichHasMaximumPoint($this->getCandidatWhichHasMaxPointFromDb());
    }



    public function calculPercentagePointOfFirstCandidat(): void
    {
    }


    public function __construct()
    {
        parent::__construct();
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setCreateTableCandidat(new CreateTableCandidat());
        $this->createTableCandidat->execute();
        $this->initializeFirstCandidat();
        $this->initializeCandidatWhichHasMaxPoint();
        $this->initializeAllCandidatData();
    }

    public function render(): void
    {
        var_dump($this->firstCandidat);
        var_dump($this->candidatWhichHasMaximumPoint);
        var_dump($this->allCandidatData);
        echo $this->getTwig()->render("homepage.html.twig");
    }
}
