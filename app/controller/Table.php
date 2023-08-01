<?php

namespace ControllerNamespace;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class Table extends AbstractTable
{
    protected string $name;
    protected $columns;
    protected $bootstrap;

    /**
     * Getter
     */
    public function getBootstrap(): Bootstrap
    {
        return $this->bootstrap;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getColumns(): ClassMetadata
    {
        return $this->columns;
    }
    public function getEntitiManager(): EntityManager
    {
        return $this->entityManager;
    }
    /**
     * Setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setColumns(ClassMetadata $columns): void
    {
        $this->columns = $columns;
    }
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
    public function setBootstrap(Bootstrap $bootstrap): void
    {
        $this->bootstrap = $bootstrap;
    }
    // -----------------------

    protected function initializeEntityManager(): void
    {
        $this->setBootstrap(Bootstrap::getInstance());
        if ($this->getBootstrap()->getEntityManager()) {
            $this->setEntityManager($this->getBootstrap()->getEntityManager());
        }
        // var_dump($this->entityManager);
    }

    public function __construct()
    {
        // $this->initializeEntityManager();
        // var_dump($this->entityManager);
    }
}
