<?php

namespace ControllerNamespace\page;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Entity\User;
use Lib\AppEntityManage;

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
        return $this->appEntityManager->getEntityManager()->getRepository(User::class)->findOneBy(["email" => $_POST["email"]]);
    }

    private function verifyPasswordCorrect(): bool
    {
        if ($this->getUserPasswrod() === $_POST['password']) {
            return true;
        }
        return false;
    }

    private function assigneUserToSessionUser(): void
    {
        if ($this->verifyIfUserExist() && $this->verifyPasswordCorrect()) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["user"] = $this->getUserLoggedData();
        }
    }

    public function initializeSession(): void
    {
        $this->assigneUserToSessionUser();
    }

    public function render(): void
    {
        echo $this->getTwig()->render("loginpage.html.twig");
        exit();
    }
}
