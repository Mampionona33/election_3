<?php

namespace ControllerNamespace;

use Lib\AppTwigEnvironment;

class LoginPageController extends UserController
{
    private $appTwigEnvironment;

    /**
     * getter
     */
    public function getAppTwigEnvironment(): AppTwigEnvironment
    {
        return $this->appTwigEnvironment;
    }
    /**
     * Setter
     */
    public function setAppTwigEnvironment(AppTwigEnvironment $appTwigEnvironment): void
    {
        $this->appTwigEnvironment = $appTwigEnvironment;
    }

    /**
     * construct
     */
    public function __construct()
    {
        $this->setAppTwigEnvironment(AppTwigEnvironment::getInstance());
    }

    public function render(): void
    {
        echo $this->getAppTwigEnvironment()->getTwig()->render("loginpage.html.twig");
    }

    public function post(): void
    {
        var_dump($_POST);
    }
}
