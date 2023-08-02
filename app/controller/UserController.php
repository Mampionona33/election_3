<?php

namespace ControllerNamespace;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Entity\User as EntityUser;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class UserController
{
    private $email;
    private string | null $password;
    private $id;
    private $twig;
    private $loader;
    protected EntityManager $entityManager;
    private CreateTableUser $createTable;
    /**
     * getter
     */

    public function getCreateTable(): CreateTableUser
    {
        return $this->createTable;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string | null
    {
        return $this->password;
    }
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
    public function getTwig(): Environment
    {
        return $this->twig;
    }
    public function getLoader(): FilesystemLoader
    {
        return $this->loader;
    }

    /**
     * setter
     */
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
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }
    public function setLoader(FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }
    // -----------------------------------
    public function __construct()
    {
        $this->initializeEntityManager();
        $this->setLoader(new FilesystemLoader(__DIR__ . '/../template'));
        $this->setTwig(new Environment($this->loader));
        // $this->createUserTableIfNotExists();
        $this->setCreatetTable(new CreateTableUser());
        $this->createTable->execute();
    }

    private function initializeEntityManager()
    {
        $bootstrap = Bootstrap::getInstance();
        $this->setEntityManager($bootstrap->getEntityManager());
    }

    public function save(): void
    {
        $user = new EntityUser();
        $user->setEmail('admin@gmail.com');
        $user->setPassword("admin");
        $user->setGroupeId(1);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function createUserTableIfNotExists(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $tables = $this->entityManager->getConnection()->createSchemaManager()->listTables();

        $userTableExists = false;
        foreach ($tables as $table) {
            if ($table->getName() === 'User') {
                $userTableExists = true;
                break;
            }
        }
        if (!$userTableExists) {
            $schemaTool->createSchema($metadata);
        }
    }

    public function index(): void
    {
        echo $this->getTwig()->render("homepage.html.twig");
        exit();
    }
}
