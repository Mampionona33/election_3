<?php

namespace ControllerNamespace\page;

use ControllerNamespace\candidat\FirstCandidatResult as CandidatFirstCandidatResult;
use Entity\tool\CreateOrUpdateTables;
use Entity\User;
use Lib\AppEntityManage;

class HomePageController extends BasePage
{
    private AppEntityManage $appEntityManage;
    private CandidatFirstCandidatResult $firstCandidatResult;
    private CreateOrUpdateTables $createTables;
    /**
     * Setter
     */
    public function setCreateTable(CreateOrUpdateTables $createTables): void
    {
        $this->createTables = $createTables;
    }

    public function setFirstCandidatResult(CandidatFirstCandidatResult $firstCandidatResult): void
    {
        $this->firstCandidatResult = $firstCandidatResult;
    }
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }

    /**
     * Getter
     */
    public function getCreateTables(): CreateOrUpdateTables
    {
        return $this->createTables;
    }

    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManage;
    }

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
        $listTableName = ["Candidat", "Authorization", "User", "Role"];
        $this->setCreateTable(new CreateOrUpdateTables($listTableName));
        $this->createTables->execute();
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
