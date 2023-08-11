<?php

namespace ControllerNamespace\page;

class CandidatPageController extends BasePage
{
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
            "user_roles" => $this->userRoles
        ]);
        exit();
    }
}
