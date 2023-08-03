<?php

namespace ControllerNamespace\page;

use ControllerNamespace\candidat\CreateTableCandidat;
use Entity\Candidat;
use Lib\AppEntityManage;

class HomePageController extends BasePage
{
    private array $listCandidat;
    private CreateTableCandidat $createTableCandidat;
    private $appEntityManage;
    private $firstCandidat;
    /**
     * Setter
     */
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
        $this->setFirstCandidat($this->getFirstCandidatFromBack());
    }

    private function  getFirstCandidatFromBack(): array
    {
        $dql = 'SELECT c FROM Entity\Candidat c WHERE c.id = (SELECT MIN(c2.id) FROM Entity\Candidat c2)';
        $query = $this->appEntityManage->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }


    public function __construct()
    {
        parent::__construct();
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setCreateTableCandidat(new CreateTableCandidat());
        $this->createTableCandidat->execute();
        $this->initializeFirstCandidat();
    }

    public function render(): void
    {
        var_dump($this->firstCandidat);
        echo $this->getTwig()->render("homepage.html.twig");
    }
}
