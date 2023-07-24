<?php
// Gestion des erreurs probables

use ControllerNamespace\AuthController;
use RouterNamespace\Router;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require 'vendor/autoload.php';



final class App
{
    private $router;
    private $loader;
    private $twig;
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
    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    public function getRouter(): Router
    {
        return $this->router;
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
    // --------------------------------------
    public function __construct()
    {
        $this->setRouter(new Router());
        $this->setAuthController(new AuthController());

        $loader = new FilesystemLoader(__DIR__ . '/template');

        // Créer l'environnement Twig avec le loader
        $twig = new Environment($loader);
        // Enregistrez l'instance Twig dans l'objet App
        $this->setTwig($twig);
    }

    public function __invoke()
    {
        $this->getRouter()->get("/", function () {
            echo $this->getTwig()->render('homepage.html.twig');
        });
        $this->getRouter()->get("/login", function () {
            echo $this->getTwig()->render("loginpage.html.twig");
        });
        $this->getRouter()->post("/login", [$this->authController, "handleLogin"]);

        $this->getRouter()->handleRequest();
    }
}

$app = new App();
$app();
