<?php
// Gestion des erreurs probables

use RouterNamespace\Router;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require 'vendor/autoload.php';


final class App
{
    private $router;

    /**
     * getter and setter
     */
    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function __construct()
    {
        $this->setRouter(new Router());
    }

    public function __invoke()
    {
        $this->getRouter()->get("/", function () {
            echo  "hello word";
        });

        $this->getRouter()->handleRequest();
    }
}

$app = new App();
$app();
