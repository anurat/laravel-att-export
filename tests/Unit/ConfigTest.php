<?php

namespace Anurat\AttExport\Tests\Unit;

use Anurat\AttExport\Facades\AttExport;
use Anurat\AttExport\Tests\TestCase;

class ConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $config = AttExport::config();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('connections', $config);
        $this->assertArrayHasKey('msaccess', $config['connections']);
        $this->assertArrayHasKey('mysql', $config['connections']);
    }

    public function testSetConfigAccess()
    {
        $options = [
            'connections' => [
                'msaccess' => [
                    'name' => "C:\\ATT2007.MDB",
                ],
            ],
        ];
        AttExport::config($options);

        $config = AttExport::config();
        $this->assertSame(
            $options['connections']['msaccess']['name'],
            $config['connections']['msaccess']['name']
        );
    }

    public function testSetConfigMysql()
    {
        $options = [
            'connections' => [
                'mysql' => [
                    'hostname' => "http://localhost",
                ],
            ],
        ];
        AttExport::config($options);

        $config = AttExport::config();
        $this->assertSame(
            $options['connections']['mysql']['hostname'],
            $config['connections']['mysql']['hostname']
        );
    }
}
