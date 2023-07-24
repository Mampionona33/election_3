<?php
// Gestion des erreurs probables
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
    public function setRouter($router): void
    {
        $this->router = $router;
    }

    public function getRouter(): AltoRouter
    {
        return $this->router;
    }

    public function __construct()
    {
        $this->setRouter(new AltoRouter());
    }

    public function handleRequest()
    {
        // Add routes here
        $this->getRouter()->map('GET', '/', function () {
            echo 'Hello, World!';
        });

        $match = $this->getRouter()->match();
        if ($match) {
            $match['target']();
        } else {
            // If no route is matched, return a 404 response
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        }
    }
}

$app = new App();
$app->handleRequest();
