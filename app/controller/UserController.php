<?php

namespace ControllerNamespace;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UserController
{
    private $email;
    private $password;
    private $id_groupe;
    private $twig;
    private $loader;
    /**
     * getter and setter
     */

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
    // -----------------------------------
    public function __construct()
    {
        $this->setLoader(new FilesystemLoader(__DIR__ . '/../template'));
        $this->setTwig(new Environment($this->loader));
    }

    public function index(): void
    {
        echo $this->getTwig()->render("homepage.html.twig");
    }

    public function login()
    {
        echo $this->getTwig()->render("loginpage.html.twig");
    }
}
