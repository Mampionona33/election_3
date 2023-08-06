<?php
// Gestion des erreurs probables

use CoffeeCode\Router\Router;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require 'vendor/autoload.php';

final class App
{
    private Router $router;
    private string $response;
    private string $baseUrl;

    /**
     * getter
     */

    public function getBasUrl(): string
    {
        return $this->baseUrl;
    }
    public function getResponse(): string
    {
        return $this->response;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
    /**
     * Setter
     */
    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }
    // --------------------------------------

    private function handleError(): void
    {
        $this->router->group("error")->namespace('ControllerNamespace');
        $this->router->get("/{errcode}", "NotFoundController:notFound");
    }

    private function redirectOnError(): void
    {
        if ($this->router->error()) {
            $this->router->redirect("/error/{$this->router->error()}");
        }
    }

    public function __construct(string $baseUrl)
    {
        $this->setBaseUrl($baseUrl);
        $this->setRouter(new Router($this->baseUrl));
    }

    private function redirectToDashboard(): void
    {
        if ($this->verifySessionExist()) {
            $this->router->redirect("/dashboard");
        }
    }


    private function  verifySessionExist(): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return !empty($_SESSION["user"]);
    }

    private function handleHomePage(): void
    {
        $requestedRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($requestedRoute === '/' || $requestedRoute === '/login') {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if ($this->verifySessionExist()) {
                    $this->router->redirect("/dashboard");
                    exit();
                } else {
                    $this->router->get("/", "HomePageController:render");
                }
            }
        } else if ($requestedRoute === '/dashboard') {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!$this->verifySessionExist()) {
                    $this->router->redirect("/login");
                    exit();
                }
            }
        }
    }

    private function handeHome(): void
    {
        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/", "HomePageController:render");
    }

    private function handleDashboard(): void
    {
        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/dashboard", "HomePageController:render");
    }

    private function handleLogin(): void
    {
        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/login", "LoginPageController:render");
        $this->router->post("/login", "LoginPageController:initializeSession");
    }

    public function __invoke()
    {

        $this->handeHome();
        $this->handleLogin();
        $this->handleDashboard();
        $this->handleError();
        $this->verifySessionExist();

        $this->handleHomePage();

        $this->setResponse($this->router->dispatch());
        $this->redirectToDashboard();
        $this->redirectOnError();
    }
}

// $app = new App("https://mampionona33-organic-couscous-64q9q79vpq7h49gw-8081.preview.app.github.dev");
$app = new App("http://localhost:8081");
$app();
