<?php

namespace ModelNamespace;

use PDO;

class DB
{
    private static $instance;
    private $user;
    private $password;
    private $dbName;
    private $host;
    private $dsn;
    private $connection;

    /**
     * getter and setter
     */
    public function setConnection(PDO $connection): void
    {
        $this->connection = $connection;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPasswrod(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function  setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }
    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function  setDsn(string $dsn): void
    {
        $this->dsn = $dsn;
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }
    private function __construct()
    {
        $this->setDbName("project_data_base");
        $this->setPassword("root");
        $this->setUser("root");
        $this->setHost("mysql");
        $this->setDsn($this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName);
    }

    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
