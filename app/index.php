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
    private string $requestPath;
    private string $requestMethod;

    /**
     * getter
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }
    public function getRequestPath(): string
    {
        return $this->requestPath;
    }
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
    public function setRequestMethod(string $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }
    public function setRequestPath(string $requestPath): void
    {
        $this->requestPath = $requestPath;
    }
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

    private function initialiseRequestPath(): void
    {
        $this->setRequestPath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    private function initializeRequestMethod(): void
    {
        $this->setRequestMethod(parse_url($_SERVER['REQUEST_METHOD'], PHP_URL_PATH));
    }

    private function handleError(): void
    {
        $this->router->group("error")->namespace('ControllerNamespace');
        $this->router->get("/{errcode}", "NotFoundController:notFound");
    }

    public function __construct(string $baseUrl)
    {
        $this->setBaseUrl($baseUrl);
        $this->setRouter(new Router($this->baseUrl));
        $this->initialiseRequestPath();
        $this->initializeRequestMethod();
    }

    private function redirectOnError(): void
    {
        if ($this->router->error()) {
            $this->router->redirect("/error/{$this->router->error()}");
        }
    }

    private function redirectToDashboardIfSessionExistOnHomePageRequest(): void
    {
        if ($this->requestPath === "/" && $this->requestMethod === "GET") {
            if ($this->verifySessionExist()) {
                $this->router->namespace("ControllerNamespace\page");
                $this->router->redirect("/dashboard");
            }
        }
    }

    private function handleHomePage(): void
    {
        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/", "HomePageController:render");
    }

    private function  verifySessionExist(): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return !empty($_SESSION["user"]);
    }

    private function redirectToHomePageIfNotSessionExistOnDashboardRequest(): void
    {
        if ($this->requestPath === "/dashboard" && $this->requestMethod === "GET") {
            if (!$this->verifySessionExist()) {
                $this->router->redirect("/");
            }
        }
    }

    private function handleDashboard(): void
    {
        $this->redirectToHomePageIfNotSessionExistOnDashboardRequest();

        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/dashboard", "HomePageController:render");
    }

    private function routLogout(): void
    {
        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/logout", "LoginPageController:destroySession");
    }

    private function handleLogin(): void
    {
        $this->router->namespace("ControllerNamespace\page");
        $this->router->get("/login", "LoginPageController:render");
        $this->router->post("/login", "LoginPageController:initializeSession");
    }

    private function redirectToDashboardOnLogginSuccessfull(): void
    {
        if ($this->requestPath === '/login' && $this->requestMethod === "POST") {
            if ($this->verifySessionExist()) {
                $this->router->redirect("/dashboard");
            }
        }
    }

    public function __invoke()
    {
        $this->handleHomePage();
        $this->handleLogin();
        $this->handleDashboard();
        $this->routLogout();

        $this->handleError();
        $this->redirectToDashboardIfSessionExistOnHomePageRequest();
        $this->setResponse($this->router->dispatch());
        $this->redirectToDashboardOnLogginSuccessfull();
        $this->redirectOnError();
    }
}

// $app = new App("https://mampionona33-organic-couscous-64q9q79vpq7h49gw-8081.preview.app.github.dev");
// $app = new App("https://mampionona33-organic-couscous-64q9q79vpq7h49gw-8081.app.github.dev");
$app = new App("http://localhost:8081");
$app();
