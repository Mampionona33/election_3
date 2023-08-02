<?php

namespace ControllerNamespace;

use App\Bootstrap;
use ControllerNamespace\candidat\CreateTableCandidat;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Entity\User as EntityUser;
use Lib\TwigEnvironment;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class UserController
{
    private $email;
    private string | null $password;
    private $id;
    private $twig;
    private $loader;
    // protected EntityManager $entityManager;
    private CreateTableUser $createTable;
    private CreateTableCandidat $createTableCandidat;
    /**
     * getter
     */
    public function getCreateTableCandidat(): CreateTableCandidat
    {
        return    $this->createTableCandidat;
    }
    public function getCreateTable(): CreateTableUser
    {
        return $this->createTable;;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string | null
    {
        return $this->password;
    }
    // public function getEntityManager(): EntityManager
    // {
    //     return $this->entityManager;
    // }
    public function getTwig(): Environment
    {
        return $this->twig;
    }
    // public function getLoader(): FilesystemLoader
    // {
    //     return $this->loader;
    // }

    /**
     * setter
     */
    public function setCreateTableCandidat(CreateTableCandidat $createTableCandidat): void
    {
        $this->createTableCandidat = $createTableCandidat;
    }
    public function setCreatetTable(CreateTableUser $createTable): void
    {
        $this->createTable = $createTable;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    // -----------------------------------
    public function __construct()
    {

        $this->setTwig(TwigEnvironment::getInstance()->getTwig());
        $this->setCreatetTable(new CreateTableUser());
        $this->createTable->execute();
        $this->setCreateTableCandidat(new CreateTableCandidat());
        $this->createTableCandidat->execute();
    }


    public function save(): void
    {
        $user = new EntityUser();
        $user->setEmail('admin@gmail.com');
        $user->setPassword("admin");
        $user->setGroupeId(1);
        // $this->entityManager->persist($user);
        // $this->entityManager->flush();
    }



    public function index(): void
    {
        echo $this->getTwig()->render("homepage.html.twig");
        exit();
    }
}
