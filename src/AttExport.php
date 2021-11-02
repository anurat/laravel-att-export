<?php

namespace Anurat\AttExport;

use Anurat\AttExport\Database\MSAccess;
use Anurat\AttExport\Database\Mysql;
use Anurat\AttExport\Export;
use Arr;

class AttExport
{
    private $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/config/config.php';
    }

    public function config(array $options = null)
    {
        if (is_null($options)) {
            return $this->config;
        }

        $this->config = array_replace_recursive($this->config, $options);

        if (Arr::has($options, 'connections.msaccess.tableNames')) {
            $this->config['connections']['msaccess']['tableNames'] = $options['connections']['msaccess']['tableNames'];
        }

        if (Arr::has($options, 'connections.mysql.tableNames')) {
            $this->config['connections']['mysql']['tableNames'] = $options['connections']['mysql']['tableNames'];
        }

        return $this;
    }

    public function convert(): void
    {
        try {
            $access = new MSAccess($this->config['connections']['msaccess']);
            $mysqlRead = new Mysql($this->config['connections']['mysql']);
            $mysqlWrite = new Mysql($this->config['connections']['mysql']);
            $export = new Export(compact('access', 'mysqlRead', 'mysqlWrite'));
            $export->fromAccessToMysql();
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
