<?php

namespace ControllerNamespace\candidat;

use ControllerNamespace\GetDataFromDbByQueryString;
use Lib\AppEntityManage;

class CandidatBase
{
    private  $name;
    private  $nbVoix;
    private  $query;
    private AppEntityManage $appEntityManage;

    /**
     * Getter
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getNbVoix(): int
    {
        return $this->nbVoix;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManage;
    }

    /**
     * Setter
     */
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNbVoix(int $nbVoix): void
    {
        $this->nbVoix = $nbVoix;
    }

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->initializeName();
        $this->initializeNbVoix();
    }
    private function getCandidatDataFromDb(): array
    {
        return   $this->appEntityManage->getEntityManager()->createQuery($this->getQuery())->getResult();
    }

    private function initializeName(): void
    {
        if (!empty($this->getCandidatDataFromDb()) && isset($this->getCandidatDataFromDb()["name"])) {
            $this->setName($this->getCandidatDataFromDb()["name"]);
        }
    }
    private function initializeNbVoix(): void
    {
        if (!empty($this->getCandidatDataFromDb()) && isset($this->getCandidatDataFromDb()["nb_voix"])) {
            $this->setNbVoix($this->getCandidatDataFromDb()["nb_voix"]);
        }
    }
}
