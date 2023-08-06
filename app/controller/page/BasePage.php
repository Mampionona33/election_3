<?php

namespace ControllerNamespace\page;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Lib\AppEntityManage;
use Lib\TwigEnvironment;
use ServiceNamespace\Service;
use Twig\Environment;

class BasePage
{
    protected Environment $twig;
    protected Service $service;
    protected AppEntityManage $appEntityManager;
    protected string $query;
    protected ResultSetMappingBuilder $resultSetMappingBuilder;
    /**
     * setter
     */
    public function setResultSetMappingBuilder(ResultSetMappingBuilder $resultSetMappingBuilder): void
    {
        $this->resultSetMappingBuilder = $resultSetMappingBuilder;
    }
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
    public function setAppEntityManage(AppEntityManage $appEntityManage): void
    {
        $this->appEntityManager = $appEntityManage;
    }
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }
    public function setService(Service $service): void
    {
        $this->service = $service;
    }

    /**
     * getter
     */
    public function getResultSetMappingBuilder(): ResultSetMappingBuilder
    {
        return $this->resultSetMappingBuilder;
    }
    public function getQuery(): string
    {
        return $this->query;
    }
    public function getAppEntityManage(): AppEntityManage
    {
        return $this->appEntityManager;
    }
    public function getTwig(): Environment
    {
        return $this->twig;
    }
    public function getService(): Service
    {
        return $this->service;
    }

    public function __construct()
    {
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setTwig(TwigEnvironment::getInstance()->getTwig());
        $this->setService(new Service());
    }
}
