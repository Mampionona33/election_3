<?php

namespace ControllerNamespace;

use Lib\AppEntityManage;

class GetDataFromDbByQueryString
{
    private AppEntityManage $appEntityManage;
    private string $query;
    /**
     * setter
     */

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
    /**
     * Getter
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    public function initializeAppEntityManage(): void
    {
        $this->appEntityManage = AppEntityManage::getInstance();
    }

    public function executeQuery(): array
    {
        return $this->appEntityManage->getEntityManager()->createQuery($this->query)->getResult();
    }


    public function __construct(string $query)
    {
        $this->query = $query;
        $this->initializeAppEntityManage();
        $this->executeQuery();
    }
}
