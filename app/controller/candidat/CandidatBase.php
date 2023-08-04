<?php

namespace ControllerNamespace\candidat;

use ControllerNamespace\candidat\AbstractCandidat as CandidatAbstractCandidat;
use Lib\AppEntityManage;

abstract class CandidatBase extends CandidatAbstractCandidat
{
    /**
     * Setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setNbVoix(int $nbVoix): void
    {
        $this->nbVoix = $nbVoix;
    }
    public function setVoicePercentage(int $voicePercentage): void
    {
        $this->voicePercentage = $voicePercentage;
    }
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
    public function setAppEntityManager(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManage = $appEntityManage;
    }

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
    public function getVoicePercentage(): int
    {
        return $this->voicePercentage;
    }
    public function getQuery(): string
    {
        return $this->query;
    }
    public function getAppEntityManager(): AppEntityManage
    {
        return $this->appEntityManage;
    }

    protected function getDataByQueryFromDb(): array
    {
        return $this->appEntityManage->getEntityManager()->createQuery($this->query)->getResult();
    }

    private function initializeName(): void
    {
        $this->setName($this->getDataByQueryFromDb()["name"]);
    }
    private function initializeNbVoix(): void
    {
        $this->setNbVoix($this->getDataByQueryFromDb()["nb_voix"]);
    }

    public function initializeAppEntityManage(): void
    {
        $this->setAppEntityManager(AppEntityManage::getInstance());
    }

    public function __construct()
    {
        $this->initializeAppEntityManage();
        $this->getDataByQueryFromDb();
        $this->initializeName();
        $this->initializeNbVoix();
    }
}
