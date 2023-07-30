<?php

namespace ControllerNamespace;

use Entity\User;
use Lib\AppEntityManage;
use Lib\AppTwigEnvironment;

class LoginPageController extends UserController
{
    private $appTwigEnvironment;
    private $appEntityManage;

    /**
     * getter
     */
    public function getAppTwigEnvironment(): AppTwigEnvironment
    {
        return $this->appTwigEnvironment;
    }
    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManage;
    }
    /**
     * Setter
     */
    public function setAppTwigEnvironment(AppTwigEnvironment $appTwigEnvironment): void
    {
        $this->appTwigEnvironment = $appTwigEnvironment;
    }
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }

    /**
     * construct
     */
    public function __construct()
    {
        $this->setAppTwigEnvironment(AppTwigEnvironment::getInstance());
        $this->setAppEntityManage(AppEntityManage::getInstance());
    }

    public function render(): void
    {
        echo $this->getAppTwigEnvironment()->getTwig()->render("loginpage.html.twig");
    }

    public function handlePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["email"])) {
                $this->setEmail($_POST["email"]);
                var_dump($this->getUserByEmail());
            }
        }
    }

    private function getUserByEmail()
    {
        return  $this->getAppEntityManage()->getEntityManager()->getRepository(User::class)->findOneBy(["email" => $this->getEmail()]);
    }
}
