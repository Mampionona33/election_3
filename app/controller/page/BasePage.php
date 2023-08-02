<?php

namespace ControllerNamespace\page;

use Lib\TwigEnvironment;
use ServiceNamespace\Service;
use Twig\Environment;

class BasePage
{
    protected Environment $twig;
    protected Service $service;
    /**
     * setter
     */
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
        $this->setTwig(TwigEnvironment::getInstance()->getTwig());
        $this->setService(new Service());
    }
}
