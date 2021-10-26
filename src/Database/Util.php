<?php

namespace Anurat\AttExport\Database;

use variant;

class Util
{
    public static function convert(string $type, variant $variant)
    {
        switch ($type) {
            case 'int':
                $value = $variant;
                break;
            case 'string':
                $value = get_class($variant) === 'variant' ? $variant->value : $variant;
                break;
            case 'date':
                $timestamp = variant_date_to_timestamp($variant);
                $value = $timestamp ? date('Y-m-d', $timestamp) : null;
                break;
            case 'datetime':
                $timestamp = variant_date_to_timestamp($variant);
                $value = $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
                break;
        }

        return $value;
    }
}
