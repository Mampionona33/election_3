<?php
// Gestion des erreurs probables

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

        // Créer un loader pour charger les templates depuis un répertoire spécifique (par exemple, 'templates')
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

        $this->getRouter()->handleRequest();
    }
}

$app = new App();
$app();
