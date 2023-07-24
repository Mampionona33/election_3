<?php

namespace ModelNamespace\SQL;

use ModelNamespace\DataBase;
use PDO;

class DataBaseManager
{
    private $connection;
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $sql;
    protected $tableName;
    protected $columns;
    protected $id_key;
    private $sqlFile;
    private $query;

    /**
     * getters and setters
     */
    public function setConnection($connection): void
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
    public function setSqlFile(string $sqlFile): void
    {
        $this->sqlFile = $sqlFile;
    }

    public function getSqlFile(): string
    {
        return $this->sqlFile;
    }

    public function setColumns(string $columns): void
    {
        $this->columns = $columns;
    }

    public function getColumns(): string
    {
        return $this->columns;
    }

    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setIdKey(string $id_key): void
    {
        $this->id_key = $id_key;
    }
    public function getIdKey(): string
    {
        return $this->id_key;
    }
    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }
    public function getSql(): string
    {
        return $this->sql;
    }
    public function setHost(string $host): void
    {
        $this->host = $host;
    }
    public function getHost(): string
    {
        return $this->host;
    }
    public function setUsername(string $username): void
    {
        $this->$username = $username;
    }
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): void
    {
        $this->$password = $password;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setDbName(string $dbname): void
    {
        $this->dbname = $dbname;
    }
    public function getDbName(): string
    {
        return $this->dbname;
    }
    //  ----------------------


    public function __construct()
    {
        $db = new DataBase();
        $this->setConnection($db->connect());
    }

    public function createTable(string $tableName, string $columnsDef): void
    {
        $sqlFile = __DIR__ . "/create_table.sql";

        if (is_file($sqlFile)) {
            $this->setSql(file_get_contents($sqlFile));

            $columnsArray = explode(',', $columnsDef);
            $columnsArray = array_map('trim', $columnsArray);
            $columnsArray = array_map('strtolower', $columnsArray);
            $columnsArray = array_unique($columnsArray);

            $tableColumns = implode(',', array_unique($columnsArray));

            // Construct the CREATE TABLE query directly with the values
            $sql = "CREATE TABLE IF NOT EXISTS $tableName ( $tableColumns );";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }


    public function executeQuery(string $query): array
    {
        $this->setSqlFile(__DIR__ . "/executeQuery.sql");
        if (is_file($this->sqlFile)) {
            $this->setSql(file_get_contents($this->sqlFile));
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }


    // Autres méthodes pour l'exécution de différentes requêtes SQL...

    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $id_key, $id)
    {
        $setValues = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $sql = "UPDATE $table SET $setValues WHERE $id_key = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute($data);
    }

    public function delete($table, $id_key, $id)
    {
        $sql = "DELETE FROM $table WHERE $id_key = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    public function findById($table, $id_key, $id)
    {
        $sql = "SELECT * FROM $table WHERE $id_key = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
