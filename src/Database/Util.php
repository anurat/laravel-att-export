<?php

namespace Anurat\AttExport\Database;

class Util
{
    public static function convert(string $type, $value)
    {
        $value = get_class($value) === 'variant' ? $value->value : $value;

        switch ($type) {
            case 'int':
                break;
            case 'string':
                break;
            case 'date':
                $date = DateTime::createFromFormat('d/m/Y', $value);
                $value = $date->format('Y-m-d');
                break;
            case 'datetime':
                $datetime = DateTime::createFromFormat('m/d/Y h:i:s a', $value);
                $value = $datetime ? $datetime->format('Y-m-d H:i:s') : null;
                break;
        }

        return $value;
    }

}
