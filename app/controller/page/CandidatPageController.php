<?php

namespace ControllerNamespace\page;

use Entity\Candidat;

class CandidatPageController extends BasePage
{
    private Candidat $candidat;

    /**
     * Getter
     */

    /**
     * Setter
     */

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
            "candidat" => []
        ]);
        exit();
    }
}
