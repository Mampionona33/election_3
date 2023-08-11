<?php

namespace ControllerNamespace\page;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Entity\User;
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
    protected array $userRoles = [];
    protected $userLogged;
    /**
     * setter
     */
    public function setUserLogged($userLogged): void
    {
        $this->userLogged = $userLogged;
    }
    public function setUserRoles(array $userRoles): void
    {
        $this->userRoles = $userRoles;
    }
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
    public function getUserLogged()
    {
        return $this->userLogged;
    }
    public function getUserRoles(): array
    {
        return $this->userRoles;
    }
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

    // ------------------------------------
    private function verifyUserLogged(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["user_id"])) {
            return true;
        }
        return false;
    }

    protected function initializeUser(): void
    {
        if ($this->verifyUserLogged()) {
            $userRepo = $this->appEntityManager->getEntityManager()->getRepository(User::class);
            $this->setUserLogged($userRepo->find($_SESSION["user_id"]));
        }
    }

    public function initilizeUserRoles(): void
    {
        if (isset($_SESSION["user_roles"])) {
            $this->setUserRoles($_SESSION["user_roles"]);
        }
    }

    public function __construct()
    {
        $this->setAppEntityManage(AppEntityManage::getInstance());
        $this->setTwig(TwigEnvironment::getInstance()->getTwig());
        $this->setService(new Service());
    }
}
