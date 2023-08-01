<?php

namespace ControllerNamespace;

use Doctrine\ORM\Tools\SchemaTool;

class CreateTable extends Table
{
    protected $metaData;
    protected $schemaTool;
    protected $dataBaseTableLists;

    /**
     * Getter
     */
    public function getMetaData()
    {
        return $this->metaData;
    }
    public function getSchemaTool(): SchemaTool
    {
        return $this->schemaTool;
    }
    public function getDataBaseTableLists()
    {
        return $this->dataBaseTableLists;
    }
    /**
     * setter
     */
    public function setMetaData($metaData): void
    {
        $this->metaData = $metaData;
    }
    public function setSchemaTool(SchemaTool $schemaTool): void
    {
        $this->schemaTool = $schemaTool;
    }
    public function setDataBaseTableLists($dataBaseTableLists): void
    {
        $this->dataBaseTableLists = $dataBaseTableLists;
    }
    // ---------------------


    private function initializeSchemaTool()
    {
        $this->setSchemaTool(new SchemaTool($this->getEntitiManager()));
    }

    private function initializeDataBaseTableLists(): void
    {
        $this->setDataBaseTableLists($this->getEntitiManager()->getConnection()->createSchemaManager()->listTables());
    }

    private function initializeMetaData(): void
    {
        $this->setMetaData($this->getEntitiManager()->getMetadataFactory());
    }

    private function verifyTableIfExist(): bool
    {
        foreach ($this->dataBaseTableLists as $table) {
            if ($table === $this->getName()) {
                return true;
            }
        }
        return false;
    }
    public function createIfNotExist(): void
    {
        if (!$this->verifyTableIfExist()) {
            $this->schemaTool->createSchema($this->metaData);
        }
    }

    public function __construct()
    {
        $this->initializeSchemaTool();
        $this->initializeDataBaseTableLists();
        $this->initializeMetaData();
    }
}
