<?php

namespace Anurat\AttExport\Database;

use Illuminate\Support\Collection;
use variant;

class SQLBuilder
{
    public function __construct($fromDB, $toDB)
    {
        $this->fromDB = $fromDB;
        $this->toDB = $toDB;
    }

    public function buildSelectSql(string $tableName, $row): string
    {
        $fromPrimaryKeys = $this->fromDB->primaryKeys($tableName);
        $toPrimaryKeys = $this->toDB->primaryKeys($tableName);

        $conditions = [];

        foreach ($fromPrimaryKeys as $i => $pk) {
            $value = Util::convert($pk['type'], $row[$pk['name']]);
            $conditions[] = "{$toPrimaryKeys[$i]['name']} = '{$value}'";
        }

        $sql = "SELECT * FROM {$tableName} WHERE ";
        $sql .= implode(' AND ', $conditions);

        return $sql;
    }

    public function buildInsertSql(string $tableName, $row): string
    {
        $fromFields = $this->fromDB->fields($tableName);
        $toFields = $this->toDB->fields($tableName);

        $values = [];
        foreach ($fromFields as $field) {
            $values[] = Util::convert($field['type'], $row[$field['name']]);
        }

        $sql = "INSERT INTO {$tableName} ( ";
        $sql .= implode(', ', array_column($toFields, 'name'));
        $sql .= " ) VALUES ( '";
        $sql .= implode("', '", $values) . "' )";

        return $sql;
    }

    public function buildUpdateSql(string $tableName, $row): string
    {
        $fromFields = $this->fromDB->fields($tableName);
        $toFields = $this->toDB->fields($tableName);
        $toPrimaryKeys = $this->toDB->primaryKeys($tableName);

        $values = [];
        foreach ($toFields as $i => $field) {
            $value = Util::convert($field['type'], $row[$fromFields[$i]['name']]);
            $values[] = (is_null($value) ?
                "{$field['name']} = null" :
                "{$field['name']} = '{$value}'");
        }

        $conditions = [];
        foreach ($toPrimaryKeys as $i => $pk) {
            $value = Util::convert($pk['type'], $row[$fromFields[$i]['name']]);
            $conditions[] = "{$pk['name']} = '{$value}'";
        }

        $sql = "UPDATE {$tableName}";
        $sql .= ' SET ' . implode(', ', $values);
        $sql .= ' WHERE ' . implode(' AND ', $conditions);

        return $sql;
    }

    public function buildPrepareSelect(string $tableName): string
    {
        $fromPrimaryKeys = $this->fromDB->primaryKeys($tableName);
        $toPrimaryKeys = $this->toDB->primaryKeys($tableName);

        $conditions = [];

        foreach ($fromPrimaryKeys as $i => $pk) {
            $conditions[] = "{$toPrimaryKeys[$i]['name']} = ?";
        }

        $sql = "SELECT * FROM {$tableName} WHERE ";
        $sql .= implode(' AND ', $conditions);

        return $sql;
    }

    public function prepareSelectParams(string $tableName, variant $row): Collection
    {
        $fromPrimaryKeys = $this->fromDB->primaryKeys($tableName);

        return collect($fromPrimaryKeys)->map(function ($pk) use ($row) {
            return Util::convert($pk['type'], $row[$pk['name']]);
        });
    }

    public function buildPrepareInsert(string $tableName): string
    {
        $toFields = $this->toDB->fields($tableName);

        $sql = "INSERT INTO {$tableName} (";
        $sql .= implode(', ', array_column($toFields, 'name'));
        $sql .= ") VALUES (";
        $sql .= implode(', ', array_fill(0, count($toFields), '?'));
        $sql .= ")";

        return $sql;
    }

    public function prepareInsertParams(string $tableName, variant $row): Collection
    {
        $fromFields = $this->fromDB->fields($tableName);

        return collect($fromFields)->map(function ($field) use ($row) {
            return Util::convert($field['type'], $row[$field['name']]);
        });
    }

    public function buildPrepareUpdate(string $tableName): string
    {
        $toFields = $this->toDB->fields($tableName);
        $toPrimaryKeys = $this->toDB->primaryKeys($tableName);

        $values = [];
        foreach ($toFields as $field) {
            $values[] = "{$field['name']} = ?";
        }

        $conditions = [];
        foreach ($toPrimaryKeys as $pk) {
            $conditions[] = "{$pk['name']} = ?";
        }

        $sql = "UPDATE {$tableName}";
        $sql .= ' SET ' . implode(', ', $values);
        $sql .= ' WHERE ' . implode(' AND ', $conditions);

        return $sql;
    }

    public function prepareUpdateParams(string $tableName, variant $row): Collection
    {
        $fromFields = $this->fromDB->fields($tableName);
        $toFields = $this->toDB->fields($tableName);
        $toPrimaryKeys = $this->toDB->primaryKeys($tableName);

        $fields = collect($toFields)->map(function ($field, int $i) use ($row, $fromFields) {
            return Util::convert($field['type'], $row[$fromFields[$i]['name']]);
        });

        $keys = collect($toPrimaryKeys)->map(function ($key, $i) use ($row, $fromFields) {
            return Util::convert($key['type'], $row[$fromFields[$i]['name']]);
        });

        return $fields->concat($keys);
    }
}
