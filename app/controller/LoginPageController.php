<?php

namespace ControllerNamespace;

use CoffeeCode\Router\Router;
use Entity\User;
use Exception;
use Lib\AppEntityManage;
use Lib\AppTwigEnvironment;

class LoginPageController extends UserController
{
    private $appTwigEnvironment;
    private $appEntityManage;
    private $router;


    /**
     * getter
     */

    public function getRouter(): Router
    {
        return $this->router;
    }
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

    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }
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



    private function initializeEmailValue(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["email"])) {
                $this->setEmail($_POST["email"]);
            }
        }
    }

    private function initializePasswordValue(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["password"])) {
                $this->setPassword($_POST["password"]);
            }
        }
    }

    private function verifyIfListUserExist(): bool
    {
        if ($this->getUserByEmail()) {
            return true;
        }
        return false;
    }

    private function verifyPasswordCorrect(): bool
    {
        if ($this->verifyIfListUserExist()) {
            $user = $this->getUserByEmail();
            $userPassword = $user->getPassword();
            return $this->getPassword() === $userPassword;
        }
        return false;
    }

    private function getUserByEmail()
    {
        return  $this->getAppEntityManage()->getEntityManager()->getRepository(User::class)->findOneBy(["email" => $this->getEmail()]);
    }

    private function assigneUserToSessionUser(): void
    {
        if (!empty($this->getUserByEmail())) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["user"] = $this->getUserByEmail();
        }
    }

    public function initializeSession(): void
    {
        $this->initializeEmailValue();
        $this->initializePasswordValue();
        if ($this->verifyPasswordCorrect()) {
            $this->assigneUserToSessionUser();
        } else {
            // throw new Exception("Error Processing Request", 1);
            echo $this->getAppTwigEnvironment()->getTwig()->render("loginpage.html.twig");
        }
    }

    public function render(): void
    {
        echo $this->getAppTwigEnvironment()->getTwig()->render("loginpage.html.twig");
    }
    public function test(): void
    {
        echo "test";
        exit();
    }
}
