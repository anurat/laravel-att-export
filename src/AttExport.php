<?php

namespace Anurat\AttExport;

use Anurat\AttExport\Database\MSAccess;
use Anurat\AttExport\Database\Mysql;
use Anurat\AttExport\Export;

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

        return $this;
    }

    public function convert(): void
    {
        try {
            $access = new MSAccess($this->config['connections']['msaccess']);
            $mysql = new Mysql($this->config['connections']['mysql']);
            $export = new Export(compact('access', 'mysql'));
            $export->fromAccessToMysql();
        } catch (Exception $e) {
            print_r($e);
        }

        return;
    }
}
