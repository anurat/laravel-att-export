<?php

namespace Anurat\AttExport\Database;

class MSAccess extends Database implements DatabaseInterface
{
    public const DRIVER = 'Microsoft Access Driver (*.mdb, *.accdb)';

    public function connect(): void
    {
        $dsn = "Driver={$this->driver};Dbq={$this->databaseName};PWD={$this->password};";
        $this->connection = new \COM("ADODB.Connection", null, CP_UTF8);
        $this->connection->open($dsn);
    }

    public function close()
    {
        return $this->connection->close();
    }

    public function read(string $tableName)
    {
        $sql = "SELECT * FROM {$tableName}";

        return $this->connection->execute($sql);
    }
}
