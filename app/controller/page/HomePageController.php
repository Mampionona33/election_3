<?php

namespace ControllerNamespace\page;

use ControllerNamespace\candidat\FirstCandidatResult as CandidatFirstCandidatResult;
use Entity\tool\CreateOrUpdateTables;
use Entity\User;

class HomePageController extends BasePage
{
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

    /**
     * Getter
     */
    public function getCreateTables(): CreateOrUpdateTables
    {
        return $this->createTables;
    }

    private function  verifySessionExist(): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return !empty($_SESSION["user_id"]);
    }

    private function getUserSession(): ?User
    {
        if ($this->verifySessionExist()) {
            $userId = $_SESSION["user_id"];
            $userRepository = $this->appEntityManager->getEntityManager()->getRepository(User::class);
            return $userRepository->find($userId);
        }
        return null;
    }

    public function __construct()
    {
        parent::__construct();
        $listTableName = ["Candidat", "User", "Role"];
        $this->setCreateTable(new CreateOrUpdateTables($listTableName));
        $this->createTables->execute();
        $this->setFirstCandidatResult(new CandidatFirstCandidatResult());
        $this->initilizeUserRoles();
    }

    public function render(): void
    {
        echo $this->getTwig()->render("homepage.html.twig", [
            "firstCandidatResult" => $this->firstCandidatResult->getResult(),
            "firstCandidatName" => $this->firstCandidatResult->getFirstCandidatName(),
            "user" => $this->getUserSession(),
            "user_roles" => $this->userRoles
        ]);
        exit();
    }
}
