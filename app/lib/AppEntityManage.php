<?php

namespace Lib;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;

final class AppEntityManage
{
    private $bootstrap;
    private static $instance;
    private $entityManager;

    /**
     * Getter
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
    public function getBootstrap(): Bootstrap
    {
        return $this->bootstrap;
    }
    /**
     * Setter
     */
    public function setBootstrap(Bootstrap $bootstrap): void
    {
        $this->bootstrap = $bootstrap;
    }
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->setBootstrap(Bootstrap::getInstance());
        $this->setEntityManager($this->bootstrap->getEntityManager());
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
