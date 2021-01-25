<?php

namespace Anurat\AttExport\Database;

class Database
{
    protected $connection;
    protected $hostname;
    protected $username;
    protected $password;

    protected $databaseName;
    protected $tableNames;
    protected $fields;

    public function __construct($options)
    {
        $this->driver = $options['driver'] ?? '';
        $this->hostname = $options['hostname'] ?? '';
        $this->username = $options['username'] ?? '';
        $this->password = $options['password'] ?? '';

        $this->databaseName = $options['databaseName'] ?? '';
        $this->tableNames = $options['tableNames'] ?? [];
        $this->fields = $options['fields'] ?? [];

        $this->connect();
    }

    public function __destruct()
    {
        $this->close();
    }

    public function tableNames(): array
    {
        return $this->tableNames;
    }

    public function primaryKeys(string $tableName): array
    {
        return array_filter($this->fields[$tableName], function ($field) {
            return array_key_exists('primaryKey', $field);
        });
    }

    public function fields(string $tableName): array
    {
        return $this->fields[$tableName];
    }
}
