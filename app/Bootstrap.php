<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

final class Bootstrap
{
    private static $instance;
    private $entityManager;
    private $paths;

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
        $this->setPaths([__DIR__ . '/entity']);
        $this->createEntityManager();
    }

    /**
     * Get the singleton instance of Bootstrap.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Setter
     */
    private function setPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    /**
     * Getter
     */
    private function getPaths(): array
    {
        return $this->paths;
    }

    private function createEntityManager(): void
    {
        // the connection configuration
        $dbParams = [
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'host' => 'mysql',
            'password' => 'root',
            'dbname'   => 'project_data_base',
        ];

        $isDevMode = true;
        $config = ORMSetup::createAttributeMetadataConfiguration($this->getPaths(), $isDevMode);
        $connection = DriverManager::getConnection($dbParams, $config);
        $this->entityManager = new EntityManager($connection, $config);
    }

    /**
     * Get the EntityManager instance.
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function addPath(string $paths): void
    {
        $this->paths[] = $paths;
    }
}
