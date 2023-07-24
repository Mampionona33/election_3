<?php

namespace ModelNamespace;

use PDO;
use PDOException;

final class DataBase
{
    private $user;
    private $password;
    private $dbName;
    private $host;
    private $dsn;
    private $connection;

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

    public function __construct()
    {
        $this->setDbName("project_data_base");
        $this->setPassword("root");
        $this->setUser("root");
        $this->setHost("mysql");
        $this->setDsn($this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName);
    }

    public function connect()
    {
        try {
            $this->setConnection(new PDO($this->dsn, $this->user, $this->password));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->connection;
        } catch (PDOException $e) {
            print "Error:" . $e->getMessage() . "<br/>";
            die();
        }
    }
}
