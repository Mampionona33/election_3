<?php

namespace ControllerNamespace;

use ModelNamespace\CandidatModel;
use ServiceNamespace\UserService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CandidatController
{
    private $twig;
    private $loader;
    private $candidatModel;
    private $authController;
    private $userService;
    /**
     * getter and sette
     */
    public function setUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }
    public function getUserService(): UserService
    {
        return $this->userService;
    }
    public function setAuthController(AuthController $authController): void
    {
        $this->authController = $authController;
    }

    public function getAuthController(): AuthController
    {
        return $this->authController;
    }

    public function setCandidatModel(CandidatModel $candidatModel): void
    {
        $this->candidatModel = $candidatModel;
    }
    public function  getCandidatModel(): CandidatModel
    {
        return $this->candidatModel;
    }
    public function setLoader(FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    public function getLoader(): FilesystemLoader
    {
        return $this->loader;
    }
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
    // -----------------------------
    public function __construct(AuthController $authController)
    {
        $this->authController = $authController;
        $this->setLoader(new FilesystemLoader(__DIR__ . '/../template'));
        $this->setTwig(new Environment($this->loader));
    }
    public function handleGet(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            if ($this->authController->isUserLogged()) {
                echo $this->getTwig()->render("candidatpage.html.twig", $this->userService->provideUserData());
            } else {
                echo $this->getTwig()->render("not authorised");
            }
        }
    }
}
