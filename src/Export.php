<?php

namespace Anurat\AttExport;

use Anurat\AttExport\Database\SQLBuilder;
use Anurat\AttExport\Database\Util;

class Export
{
    protected $access;
    protected $mysql;

    protected $fromDB;
    protected $toDB;

    public function __construct(array $options)
    {
        $this->access = $options['access'];
        $this->mysql = $options['mysql'];
    }

    public function fromAccessToMysql(): void
    {
        $this->fromDB = $this->access;
        $this->toDB = $this->mysql;

        $tableNames = $this->fromDB->tableNames();
        foreach ($tableNames as $tableName) {
            echo "\n" . $tableName;
            $this->processTables($tableName);
        }
    }

    private function processTables($tableName): void
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read($tableName);
        while (!$accessResult->EOF) {
            // find a row in mysql that matches a row in access
            $sql = $builder->buildSelectSql($tableName, $accessResult->fields);
            $mysqlResult = $this->mysql->query($sql);
            $mysqlRow = $mysqlResult->fetch();

            // if not found, insert new row
            if (empty($mysqlRow)) {
                $sql = $builder->buildInsertSql($tableName, $accessResult->fields);
                if (!$this->mysql->exec($sql)) {
                    $this->mysql->errorInfo();
                }
            } elseif (!$this->hasSameValues($tableName, $accessResult->fields, $mysqlRow)) {
                // if found a matched row but different values, update the row
                $sql = $builder->buildUpdateSql($tableName, $accessResult->fields);

                echo $sql;

                if (!$this->mysql->exec($sql)) {
                    $this->mysql->errorInfo();
                }
            }

            echo '.';

            $accessResult->moveNext();
        }
    }

    private function hasSameValues($tableName, $fromRow, $toRow): bool
    {
        $from_fields = $this->fromDB->fields($tableName);

        foreach ($from_fields as $i => $field) {
            $value = Util::convert($field['type'], $fromRow[$field['name']]);
            if ($toRow[$i] != $value) {
                echo $toRow[$i] . ' ' . $value . "\n";

                return false;
            }
        }

        return true;
    }
}
