<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;


final class Bootstrap
{
    private $paths;

    /**
     * Setter for paths
     */
    public function setPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    /**
     * Getter for paths
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    public function __construct()
    {
        $this->setPaths([__DIR__ . '/entity']);
    }

    public function createEntityManager(): EntityManager
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
        $entityManager = new EntityManager($connection, $config);
        return $entityManager;
    }
}
