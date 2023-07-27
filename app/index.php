<?php
// Gestion des erreurs probables

use ControllerNamespace\AuthController;
use ControllerNamespace\AuthorizationController;
use ControllerNamespace\CandidatController;
use ControllerNamespace\PageController;
use RouterNamespace\Router;
use ServiceNamespace\UserService;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require 'vendor/autoload.php';



final class App
{
    private $router;
    private $authController;
    private $pageController;
    private $candidatController;
    private $userService;
    private $authorizationController;
    /**
     * getter and setter
     */
    public function setAuthorzationController(AuthorizationController $authorizationController): void
    {
        $this->authorizationController = $authorizationController;
    }

    public function getAuthorzationController(): AuthorizationController
    {
        return $this->authorizationController;
    }
    public function setUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }
    public function getUserService(): UserService
    {
        return $this->userService;
    }
    public function setCandidatController(CandidatController $candidatController): void
    {
        $this->candidatController = $candidatController;
    }
    public function getCandidatController(): CandidatController
    {
        return $this->candidatController;
    }
    public function setPageController(PageController $pageController): void
    {
        $this->pageController = $pageController;
    }

    public function getPageController(): PageController
    {
        return $this->pageController;
    }
    public function setAuthController(AuthController $authController): void
    {
        $this->authController = $authController;
    }

    public function getAuthController(): AuthController
    {
        return $this->authController;
    }
    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    // --------------------------------------
    public function __construct()
    {
        $this->setRouter(new Router());
        $this->setAuthController(new AuthController());
        $this->setAuthorzationController(new AuthorizationController());
        $this->setUserService(new UserService($this->authController, $this->authorizationController));
        $this->setPageController(new PageController());
        $this->pageController->setUserService($this->getUserService());
        $this->setCandidatController(new CandidatController($this->authController));
        $this->candidatController->setUserService($this->getUserService());
        $this->pageController->setAuthController($this->authController);
    }


    public function __invoke()
    {
        $this->getRouter()->get("/", [$this->pageController, "handleHomePage"]);
        $this->getRouter()->get("/login", [$this->pageController, "handleLogin"]);
        $this->getRouter()->get("/dashboard", [$this->pageController, "handleDashboard"]);
        $this->getRouter()->post("/login", [$this->authController, "handleLogin"]);
        $this->getRouter()->get("/logout", [$this->authController, "handleLogout"]);
        $this->getRouter()->get("/candidat", [$this->candidatController, "handleGet"]);

        $this->getRouter()->handleRequest();
    }
}

$app = new App();
$app();
