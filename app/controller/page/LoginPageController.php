<?php

namespace ControllerNamespace\page;

use CoffeeCode\Router\Router;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Entity\User;
use Lib\AppEntityManage;
use Lib\AppTwigEnvironment;

class LoginPageController extends BasePage
{

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
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

    private function verifyIfUserExist(): bool
    {
        $userRepository = $this->appEntityManager->getEntityManager()->getRepository(User::class);
        $user = $userRepository->findOneBy(["email" => $_POST["email"]]);
        return $user !== null;
    }

    private function getUserPasswrod(): string
    {
        $this->setQuery("SELECT password FROM User WHERE email = '" . $_POST["email"] . "'");
        $this->setResultSetMappingBuilder(new ResultSetMappingBuilder($this->appEntityManager->getEntityManager()));
        $this->resultSetMappingBuilder->addScalarResult('password', 'password');
        return $this->appEntityManager->getEntityManager()->createNativeQuery($this->query, $this->resultSetMappingBuilder)->getSingleScalarResult();
    }

    private function getUserLoggedData()
    {
        var_dump($this->getUserPasswrod());
    }

    private function verifyPasswordCorrect(): bool
    {
        if ($this->getUserPasswrod() === $_POST['password']) {
            return true;
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
        // $this->initializeEmailValue();
        // $this->initializePasswordValue();
        var_dump($this->verifyPasswordCorrect());


        // if ($this->verifyPasswordCorrect()) {
        //     $this->assigneUserToSessionUser();
        // } else {
        //     $this->render();
        // }
    }

    public function render(): void
    {
        echo $this->getTwig()->render("loginpage.html.twig");
        exit();
    }
}
