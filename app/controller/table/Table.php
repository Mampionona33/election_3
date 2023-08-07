<?php

namespace ControllerNamespace\table;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;

class Table extends AbstractTable
{
    /**
     * Setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }
    public function setBootstrap(Bootstrap $bootstrap): void
    {
        $this->bootstrap = $bootstrap;
    }
    public function  setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
    /**
     * Getter
     */
    public function getName(): string
    {
        return $this->name;
    }
    public function  getColumns(): array
    {
        return $this->columns;
    }
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
    public function getBootstrap(): Bootstrap
    {
        return $this->bootstrap;
    }
    // ----------------------------
    private function initializeEntityManager(): void
    {
        $this->setBootstrap(Bootstrap::getInstance());
        $this->setEntityManager($this->bootstrap->getEntityManager());
    }
    public function __construct()
    {
        $this->initializeEntityManager();
    }
}
