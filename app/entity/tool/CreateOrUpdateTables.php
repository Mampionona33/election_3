<?php

namespace Entity\tool;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class CreateOrUpdateTables
{
    private SchemaTool $schemaTool;
    private array $dataBaseTablesList;
    private array $listTableName;
    protected Bootstrap $bootstrap;
    protected EntityManager $entityManager;

    /**
     * Setter
     */
    public function  setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
    public function setBootstrap(Bootstrap $bootstrap): void
    {
        $this->bootstrap = $bootstrap;
    }
    public function setListTableName(array $listTableName): void
    {
        $this->listTableName = $listTableName;
    }
    public function setSchemaTool(SchemaTool $schemaTool): void
    {
        $this->schemaTool = $schemaTool;
    }
    public function setDataBaseTablesList(array $dataBaseTablesList): void
    {
        $this->dataBaseTablesList = $dataBaseTablesList;
    }

    /**
     * Getter
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
    public function getBootstrap(): Bootstrap
    {
        return $this->bootstrap;
    }
    public function getListTableName(): array
    {
        return $this->listTableName;
    }
    public function getSchemaTool(): SchemaTool
    {
        return $this->schemaTool;
    }
    public function getDataBaseTablesList(): array
    {
        return $this->dataBaseTablesList;
    }

    public function verifyIfTableExist(): bool
    {
        foreach ($this->dataBaseTablesList as $table) {
            if (in_array($table->getName(), $this->listTableName)) {
                return true;
            }
        }
        return false;
    }

    public function execute(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!$this->verifyIfTableExist()) {
            $this->schemaTool->createSchema($metadata);
        } else {
            $this->schemaTool->updateSchema($metadata);
        }
    }

    private function initializeEntityManager(): void
    {
        $this->setBootstrap(Bootstrap::getInstance());
        $this->setEntityManager($this->bootstrap->getEntityManager());
    }

    public function __construct(array $listTableName)
    {
        $this->setListTableName($listTableName);
        $this->initializeEntityManager();
        $this->setSchemaTool(new SchemaTool($this->entityManager));
        $this->setDataBaseTablesList($this->entityManager->getConnection()->createSchemaManager()->listTables());
    }
}
