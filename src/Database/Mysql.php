<?php

namespace Anurat\AttExport\Database;

use Log;
use PDOStatement;

class Mysql extends Database implements DatabaseInterface
{
    public function connect()
    {
        $dsn = "mysql:host={$this->hostname};dbname={$this->databaseName};charset=utf8mb4";
        $this->connection = new \PDO($dsn, $this->username, $this->password);
        $this->connection->query("SET character_set_connection=utf8mb4");
        $this->connection->query("SET character_set_client=utf8mb4");
        $this->connection->query("SET character_set_results=utf8mb4");
    }

    public function close()
    {
        $this->connection = null;
    }

    public function query(string $sql)
    {
        return $this->connection->query($sql);
    }

    public function exec(string $sql)
    {
        return $this->connection->exec($sql);
    }

    public function prepare(string $sql): PDOStatement
    {
        return $this->connection->prepare($sql);
    }

    public function errorInfo(): void
    {
        Log::debug($this->connection->errorInfo());
    }
}
