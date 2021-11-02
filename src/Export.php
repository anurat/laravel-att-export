<?php

namespace Anurat\AttExport;

use Anurat\AttExport\Database\SQLBuilder;
use Anurat\AttExport\Database\Util;
use Log;

class Export
{
    protected $access;
    protected $mysqlRead;
    protected $mysqlWrite;

    protected $fromDB;
    protected $toDBRead;
    protected $toDBWrite;

    public function __construct(array $options)
    {
        $this->fromDB = $this->access = $options['access'];
        $this->toDBRead = $this->mysqlRead = $options['mysqlRead'];
        $this->toDBWrite = $this->mysqlWrite = $options['mysqlWrite'];
    }

    public function fromAccessToMysql(): void
    {
        $tableNames = $this->fromDB->tableNames();
        foreach ($tableNames as $tableName) {
            Log::debug($tableName);
            $this->processTables($tableName);
        }
    }

    private function processTables($tableName): void
    {
        $builder = new SQLBuilder($this->fromDB, $this->toDBRead);

        $accessResult = $this->fromDB->read($tableName);

        $sql = $builder->buildPrepareSelect($tableName);
        $selectStmt = $this->toDBRead->prepare($sql);
        $sql = $builder->buildPrepareInsert($tableName);
        $insertStmt = $this->toDBWrite->prepare($sql);
        $sql = $builder->buildPrepareUpdate($tableName);
        $updateStmt = $this->toDBWrite->prepare($sql);

        while (!$accessResult->EOF) {
            // find a row in mysql that matches a row in access
            $params = $builder->prepareSelectParams($tableName, $accessResult->fields);
            $selectStmt->execute(array_values($params->toArray()));
            $mysqlRow = $selectStmt->fetch();

            // if not found, insert new row
            if (empty($mysqlRow)) {
                $params = $builder->prepareInsertParams($tableName, $accessResult->fields);
                if (!$insertStmt->execute($params->toArray())) {
                    $this->mysql->errorInfo();
                }
            } elseif (!$this->hasSameValues($tableName, $accessResult->fields, $mysqlRow)) {
                // if found a matched row but different values, update the row
                $params = $builder->prepareUpdateParams($tableName, $accessResult->fields);
                if (!$updateStmt->execute($params->toArray())) {
                    $this->mysql->errorInfo();
                }
            }

            $accessResult->moveNext();
        }
    }

    private function hasSameValues($tableName, $fromRow, $toRow): bool
    {
        $from_fields = $this->fromDB->fields($tableName);

        foreach ($from_fields as $i => $field) {
            $value = Util::convert($field['type'], $fromRow[$field['name']]);
            if ($toRow[$i] != $value) {
                Log::debug($toRow[$i] . ' ' . $value);

                return false;
            }
        }

        return true;
    }
}
