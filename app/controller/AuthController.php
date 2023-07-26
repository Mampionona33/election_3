<?php

namespace ControllerNamespace;

use Error;
use ModelNamespace\AuthorizationModel;
use ModelNamespace\UserModel;

class AuthController
{
    private $userLogged;
    private $userModel;
    private $userRoles;
    private $authorizationModel;

    /**
     * getter and setter
     */

    public function getAuthorizationModel(): AuthorizationModel
    {
        return $this->authorizationModel;
    }

    public function setAuthorizationModel(AuthorizationModel $authorizationModel): void
    {
        $this->authorizationModel = $authorizationModel;
    }

    public function setUserRoles(array $userRoles): void
    {
        $this->userRoles = $userRoles;
    }

    public function getUserRoles(): array
    {
        return $this->userRoles;
    }

    public function setUserModel(UserModel $userModel): void
    {
        $this->userModel = $userModel;
    }

    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }

    public function setUserLogged(array $userLogged): void
    {
        $this->userLogged = $userLogged;
    }

    public function getUserLogged(): ?array
    {
        if (isset($_SESSION["user"])) {
            return $_SESSION["user"];
        }
        return null;
    }
    // --------------------------------

    public function __construct()
    {
        $this->setUserModel(new UserModel());
        $this->setAuthorizationModel(new AuthorizationModel());
    }

    public function isUserLogged(): bool
    {
        return isset($_SESSION["user"]);
    }

    public function handleLogout(): void
    {
        header("Location: /");
        session_start();
        session_destroy();
        exit();
    }

    public function handleLogin(): void
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $user = $this->userModel->getByEmail($_POST);
            $this->setUserLogged($user);

            if (!empty($this->userLogged)) {
                $this->saveUserToSession();
                $this->saveUserRoleToSession();
                header("Location: /dashboard");
                exit();
            } else {
                header("Location: /login");
                exit();
            }
        } else {
            throw new Error("Email and password are required", 1);
        }
    }

    private function saveUserRoleToSession(): void
    {
        if (!empty($this->userLogged)) {
            $this->setUserRoles($this->authorizationModel->getGroupeRoles($this->userLogged[0]["id_groupe"]));
        }
        if (!empty($this->userRoles)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["user_roles"] = $this->userRoles;
        }
    }

    private function saveUserToSession(): void
    {
        if (!empty($this->userLogged)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["user"] = $this->userLogged;
        }
    }
}
