<?php

namespace ControllerNamespace\candidat;

use Lib\AppEntityManage;

class CandidatController
{
    protected string $name;
    protected int $nbVoix;
    protected AppEntityManage $appEntityManage;
    protected string $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNbVoix(int $nbVoix): void
    {
        $this->nbVoix = $nbVoix;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNbVoix(): int
    {
        return $this->nbVoix;
    }

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function initializeAppEntityManage(): void
    {
        $this->appEntityManage = AppEntityManage::getInstance();
    }

    protected function getDataByQueryFromDb(): array
    {
        return $this->appEntityManage->getEntityManager()->createQuery($this->query)->getResult();
    }

    public function initializeName(): void
    {
        $data = $this->getDataByQueryFromDb();
        if (isset($data["name"])) {
            $this->setName($data["name"]);
        }
    }

    public function initializeNbVoix(): void
    {
        $data = $this->getDataByQueryFromDb();
        if (isset($data["nb_voix"])) {
            $this->setNbVoix($data["nb_voix"]);
        }
    }

    public function initializeCandidat(): void
    {
        $this->initializeAppEntityManage();
        $this->getDataByQueryFromDb();
        $this->initializeName();
        $this->initializeNbVoix();
    }
}
