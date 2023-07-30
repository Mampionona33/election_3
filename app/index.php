<?php
// Gestion des erreurs probables

use CoffeeCode\Router\Router;
use Doctrine\ORM\EntityManager;



error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require 'vendor/autoload.php';

final class App
{
    private $router;
    private $response;
    private $entityManager;

    /**
     * getter and setter
     */
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    public function getResponse(): string
    {
        return $this->response;
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

    public function __construct()
    {
        $this->setRouter(new Router("http://localhost:8081"));
        $this->router->namespace("ControllerNamespace");
    }

    public function __invoke()
    {
        $this->router->get("/", "UserController:index");
        $this->router->get("/login", "UserController:login");

        $this->handleError();
        $this->setResponse($this->router->dispatch());
        $this->redirectOnError();
    }
}

$app = new App();
$app();
