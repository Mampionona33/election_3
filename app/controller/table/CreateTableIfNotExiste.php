<?php

namespace ControllerNamespace\table;

use ControllerNamespace\table\Table;
use Doctrine\ORM\Tools\SchemaTool;

class CreateTableIfNotExiste extends Table
{
    protected SchemaTool $schemaTool;
    protected array $dataBaseTablesList;

    /**
     * Setter
     */
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
    public function getSchemaTool(): SchemaTool
    {
        return $this->schemaTool;
    }
    public function getDataBaseTablesList(): array
    {
        return $this->dataBaseTablesList;
    }
    // ------------------------------------

    private function verifyIfTableExist(): bool
    {
        foreach ($this->dataBaseTablesList as $table) {
            if ($this->getName() === $table->getName()) {
                return true;
            }
        }
        return false;
    }

    public function execute(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!$this->verifyIfTableExist()) $this->schemaTool->createSchema($metadata);
    }

    public function __construct()
    {
        parent::__construct();
        $this->setSchemaTool(new SchemaTool($this->entityManager));
        $this->setDataBaseTablesList($this->entityManager->getConnection()->createSchemaManager()->listTables());
    }
}
