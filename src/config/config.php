<?php

set_time_limit(0);
date_default_timezone_set('Asia/Bangkok');
include_once __DIR__ . '/constants.php';

return [

    'connections' => [

        'msaccess' => [
            'driver' => MSACCESS_DRIVER,
            'password' => MSACCESS_PASSWORD,
            'databaseName' => MSACCESS_DATABASE,
            'tableNames' => MSACCESS_TABLE_NAMES,
            'fields' => MSACCESS_FIELDS,
        ],

        'mysql' => [
            'hostname' => MYSQL_HOSTNAME,
            'username' => MYSQL_USERNAME,
            'password' => MYSQL_PASSWORD,
            'databaseName' => MYSQL_DATABASE,
            'tableNames' => MYSQL_TABLE_NAMES,
            'fields' => MYSQL_FIELDS,
        ],
    ],
];
