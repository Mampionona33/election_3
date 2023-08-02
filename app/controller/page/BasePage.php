<?php

namespace ControllerNamespace\page;

use Lib\AppEntityManage;
use Lib\TwigEnvironment;
use ServiceNamespace\Service;
use Twig\Environment;

class BasePage
{
    protected Environment $twig;
    protected Service $service;
    protected AppEntityManage $appEntityManager;
    /**
     * setter
     */
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
