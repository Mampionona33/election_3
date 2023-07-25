<?php

namespace ControllerNamespace;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class PageController
{
    private $twig;
    private $loader;
    private $authController;

    /**
     * getter and setter
     */
    public function setAuthController(AuthController $authController): void
    {
        $this->authController = $authController;
    }

    public function getAuthController(): AuthController
    {
        return $this->authController;
    }

    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }

    public function setLoader(FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    public function getLoader(): FilesystemLoader
    {
        return $this->loader;
    }

    public function __construct(AuthController $authController)
    {
        $this->authController = $authController;
        $this->setLoader(new FilesystemLoader(__DIR__ . '/../template'));
        $this->setTwig(new Environment($this->loader));
    }

    public function handleHomePage(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            if ($this->authController->isUserLogged()) {
                $this->redirectDashboard();
            } else {
                echo $this->getTwig()->render("homepage.html.twig");
            }
        }
    }

    public function handleDashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            if ($this->authController->isUserLogged()) {
                echo $this->getTwig()->render("homepage.html.twig", ["user" => $this->authController->getUserLogged()]);
            } else {
                $this->redirectVisitorHomePage();
            }
        }
    }

    public function handleLogin(): void
    {
        echo $this->getTwig()->render("loginpage.html.twig");
    }

    private function redirectVisitorHomePage(): void
    {
        header("Location: /");
        session_destroy();
        exit();
    }

    private function redirectDashboard(): void
    {
        header("Location: /dashboard");
        exit();
    }
}