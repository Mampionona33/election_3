<?php

namespace ControllerNamespace;

class AuthorizationController
{
    public const CREATE_CANDIDAT = "create-candidat";
    public const UPDATE_CANDIDAT = "update-candidat";
    public const DELETE_CANDIDAT = "delete-candidat";

    public function canManageCandidats(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION["user"]) && !empty($_SESSION["user_roles"]) && isset($_SESSION["user_roles"])) {
            foreach ($_SESSION["user_roles"] as $role) {
                if (
                    isset($role["slug"])
                    && $role["slug"] === self::CREATE_CANDIDAT
                    || $role["slug"] === self::UPDATE_CANDIDAT
                    || $role["slug"] === self::DELETE_CANDIDAT
                ) {
                    return true;
                }
            }
        }
        return false;
    }
}
