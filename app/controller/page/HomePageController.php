<?php

namespace ControllerNamespace\page;

use ControllerNamespace\candidat\CreateTableCandidat;
use ControllerNamespace\candidat\FirstCandidatResult as CandidatFirstCandidatResult;
use ControllerNamespace\user\CreateTableUser;
use Entity\User;
use Lib\AppEntityManage;

class HomePageController extends BasePage
{
    private CreateTableUser $createTableUser;
    private CreateTableCandidat $createTableCandidat;
    private AppEntityManage $appEntityManage;
    private CandidatFirstCandidatResult $firstCandidatResult;

    /**
     * Setter
     */
    public function setCreateTableUser(CreateTableUser $createTableUser): void
    {
        $this->createTableUser = $createTableUser;
    }
    public function setFirstCandidatResult(CandidatFirstCandidatResult $firstCandidatResult): void
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
    public function getCreateTableUser(): CreateTableUser
    {
        return $this->createTableUser;
    }
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
    private function  verifySessionExist(): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return !empty($_SESSION["user"]);
    }

    private function getUserSession(): ?User
    {
        if ($this->verifySessionExist()) {
            return   $_SESSION["user"];
        }
        return null;
    }

    public function __construct()
    {
        parent::__construct();
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setCreateTableCandidat(new CreateTableCandidat());
        $this->createTableCandidat->execute();
        $this->setCreateTableUser(new CreateTableUser());
        $this->createTableUser->execute();
        $this->setFirstCandidatResult(new CandidatFirstCandidatResult());
    }

    public function render(): void
    {
        echo $this->getTwig()->render("homepage.html.twig", [
            "firstCandidatResult" => $this->firstCandidatResult->getResult(),
            "firstCandidatName" => $this->firstCandidatResult->getFirstCandidatName(),
            "user" => $this->getUserSession()
        ]);
        exit();
    }
}
