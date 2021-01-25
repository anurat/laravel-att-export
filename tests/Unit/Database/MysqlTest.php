<?php

namespace Anurat\AttExport\Tests\Unit;

use Anurat\AttExport\Database\Mysql;
use Anurat\AttExport\Tests\TestCase;

class MysqlTest extends TestCase
{
    public function testConnect()
    {
        $mysql = new Mysql([
            'hostname' => 'att2.rs.cri.or.th',
            'username' => 'dba',
            'password' => '25ed8c4ad7',
            'databaseName' => 'att',
        ]);

        $result = $mysql->query('SELECT * FROM leaveclass');

        $data = $result->fetchAll();

        $this->assertIsArray($data);
        $this->assertCount(11, $data);
    }
}
