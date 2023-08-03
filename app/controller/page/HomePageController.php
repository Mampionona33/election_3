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
    /**
     * Setter
     */
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

    private function getCandidatListFromDb(): void
    {
        $candidat = $this->appEntityManage->getEntityManager()->getRepository(Candidat::class)->findAll();
        var_dump($candidat);
    }

    public function __construct()
    {
        parent::__construct();
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setCreateTableCandidat(new CreateTableCandidat());
        $this->createTableCandidat->execute();
    }

    public function render(): void
    {
        var_dump($this->getCandidatListFromDb());
        echo $this->getTwig()->render("homepage.html.twig");
    }
}
