<?php

namespace ServiceNamespace;

use ControllerNamespace\AuthController;
use ControllerNamespace\AuthorizationController;
use ControllerNamespace\CandidatController;
use ModelNamespace\CandidatModel;

class UserService
{
    private $authController;
    private $authorizationController;
    private $userInfo;
    private $candidatModel;
    private $candidatController;

    /**
     * getter and setter
     */
    // public function setCandidaController(CandidatController $candidatController): void
    // {
    //     $this->candidatController = $candidatController;
    // }
    // public function getCandidatController(): CandidatController
    // {
    //     return $this->candidatController;
    // }
    // public function getCandidatModel(): CandidatModel
    // {
    //     return $this->candidatModel;
    // }
    // public function setCandidatModel(CandidatModel $candidatModel): void
    // {
    //     $this->candidatModel = $candidatModel;
    // }
    // public function setUserInfo(array $userInfo): void
    // {
    //     $this->userInfo = $userInfo;
    // }
    // public function getUserInfo(): array
    // {
    //     return $this->userInfo;
    // }
    // public function setAuthController(AuthController $authController): void
    // {
    //     $this->authController = $authController;
    // }
    // public function getAuthController(): AuthController
    // {
    //     return $this->authController;
    // }

    // public function setAuthorizationController(AuthorizationController $authorizationController): void
    // {
    //     $this->authController = $authorizationController;
    // }
    // public function getAuthorizationController(): AuthorizationController
    // {
    //     return $this->authorizationController;
    // }
    // --------------------------------
    // public function __construct(AuthController $authController, AuthorizationController $authorizationController)
    // {
    //     $this->setCandidatModel(new CandidatModel());
    //     $this->setCandidaController(new CandidatController());
    //     $this->authController = $authController;
    //     $this->authorizationController = $authorizationController;
    // }

    // public function provideUserData(): array
    // {
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }
    //     if ($this->authController->isUserLogged()) {
    //         $this->userInfo["user"] = $this->authController->getUserLogged();
    //         $this->userInfo["canManageCandidats"] = $this->authorizationController->canManageCandidats();
    //     }
    //     // var_dump($this->candidatModel->getCandidatWithMaxPoint());
    //     $this->userInfo["candidats"] = $this->candidatModel->getAllWithPercentage();
    //     return $this->userInfo;
    // }
}
