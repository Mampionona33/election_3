<?php

namespace ControllerNamespace\page;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Entity\User;

class LoginPageController extends BasePage
{
    /**
     * Getter
     */

    /**
     * Setter
     */

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
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

    private function getUserLoggedData(): ?User
    {
        $userRepository = $this->appEntityManager->getEntityManager()->getRepository(User::class);
        return $userRepository->findOneBy(["email" => $_POST["email"]]);
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
            $user = $this->getUserLoggedData();
            if ($user !== null) {
                $_SESSION["user_id"] = $user->getId();
            }
        }
    }

    public function assigneUserRoleToSession(): void
    {
        if ($this->verifyIfUserExist() && isset($_SESSION["user_id"])) {
            $this->initializeUser();
            $groupe = $this->userLogged->getGroupe();
            if ($groupe) {
                $roles = $groupe->getRoles();
                $roleNames = [];
                foreach ($roles as $role) {
                    $roleNames[] = $role->getSlug();
                }
                $_SESSION["user_roles"] = $roleNames;
            }
        }
    }

    public function destroySession(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // Détruire la session
            session_unset();
            session_destroy();
            // Rediriger vers la page d'accueil
            header("Location: /");
            exit();
        }
    }

    public function initializeSession(): void
    {
        $this->assigneUserToSessionUser();
        $this->assigneUserRoleToSession();
    }

    public function render(): void
    {
        echo $this->getTwig()->render("loginpage.html.twig");
        exit();
    }
}
