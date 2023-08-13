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

    // ------------------------------

    private function calculatePercentage(Candidat $candidat, array $candidats): float
    {
        $totalVoix = $this->getTotalVoix($candidats);
        if ($totalVoix > 0) {
            return round(($candidat->getNbVoix() / $totalVoix) * 100, 2);
        }
        return 0.0;
    }

    private function getTotalVoix(array $candidats): int
    {
        $total = 0;
        foreach ($candidats as $candidat) {
            $total += $candidat->getNbVoix();
        }
        return $total;
    }

    public function generateCandidatList(): array
    {
        $candidatRepo = $this->appEntityManager->getEntityManager()->getRepository(Candidat::class);
        $candidats = $candidatRepo->findAll();

        $candidatList = [];
        foreach ($candidats as $candidat) {
            $percentage = $this->calculatePercentage($candidat, $candidats);
            $candidatList[] = [
                'id' => $candidat->getId(),
                'name' => $candidat->getName(),
                'nbVoix' => $candidat->getNbVoix(),
                'percentage' => $percentage,
            ];
        }

        return $candidatList;
    }

    public function __construct()
    {
        parent::__construct();
        $this->initializeUser();
        $this->initilizeUserRoles();
    }

    public function render(): void
    {
        echo $this->getTwig()->render("candidatpage.html.twig", [
            "user" => $this->userLogged, "user_roles" => $this->userRoles,
            "user_roles" => $this->userRoles,
            "candidats" => $this->generateCandidatList()
        ]);
        exit();
    }
}
