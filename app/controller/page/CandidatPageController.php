<?php

namespace ControllerNamespace\page;

use Entity\Candidat;

class CandidatPageController extends BasePage
{
    private Candidat $candidat;

    /**
     * Getter
     */
    public function getCandidat(): Candidat
    {
        return $this->candidat;
    }
    /**
     * Setter
     */
    public function setCandidat(Candidat $candidat): void
    {
        $this->candidat = $candidat;
    }

    // private function generateCandidatList(): array
    // {
    //     $candidatRepo = $this->appEntityManager->getEntityManager()->getRepository(Candidat::class);
    //     $candidats = $candidatRepo->findAll();
    //     return $candidats ?? [];
    // }

    private function generateCandidatList(): array
    {
        $candidatRepo = $this->appEntityManager->getEntityManager()->getRepository(Candidat::class);

        $candidats = $candidatRepo->createQueryBuilder('candidat')
            ->select('candidat')
            ->getQuery()
            ->getResult();

        return $candidats ?? [];
    }


    public function __construct()
    {
        parent::__construct();
        $this->initializeUser();
        $this->initilizeUserRoles();
    }

    public function render(): void
    {
        var_dump($this->generateCandidatList());
        echo $this->getTwig()->render("candidatpage.html.twig", [
            "user" => $this->userLogged, "user_roles" => $this->userRoles,
            "user_roles" => $this->userRoles,
            "candidats" => $this->generateCandidatList()
        ]);
        exit();
    }
}
