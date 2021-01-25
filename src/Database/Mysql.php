<?php

namespace Anurat\AttExport\Database;

class Mysql extends Database implements DatabaseInterface
{
    public function connect()
    {
        $dsn = "mysql:host={$this->hostname};dbname={$this->databaseName};charset=utf8";
        $this->connection = new \PDO($dsn, $this->username, $this->password);
        $this->connection->query("SET character_set_connection=utf8mb4");
        $this->connection->query("SET character_set_client=utf8mb4");
        $this->connection->query("SET character_set_results=utf8mb4");
    }

    public function close()
    {
        return $this->connection = null;
    }

    public function query(string $sql)
    {
        return $this->connection->query($sql);
    }

    public function exec(string $sql)
    {
        return $this->connection->exec($sql);
    }

    public function errorInfo(): void
    {
        print_r($this->connection->errorInfo());
    }
}
