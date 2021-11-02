<?php

namespace Anurat\AttExport\Tests\Unit\Database;

use Anurat\AttExport\Database\MSAccess;
use Anurat\AttExport\Database\Mysql;
use Anurat\AttExport\Database\SQLBuilder;
use Anurat\AttExport\Tests\TestCase;

class RunPrepareTest extends TestCase
{
    public function setUp(): void
    {
        $config = include __DIR__ . '/../../../src/config/config.php';

        $this->access = new MSAccess($config['connections']['msaccess']);
        $this->mysql = new Mysql($config['connections']['mysql']);
    }

    public function tearDown(): void
    {
        $this->mysql->close();
    }

    public function testRunSelect()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read('leaveclass');
        $sql = $builder->buildPrepareSelect('leaveclass');
        $params = $builder->prepareSelectParams('leaveclass', $accessResult->fields);
        $selectStmt = $this->mysql->prepare($sql);
        $selectStmt->execute($params->toArray());
        $result = $selectStmt->fetch();
        $expected = [
            'id' => '1',
            'leavename' => 'ลาป่วย',
            0 => '1',
            1 => 'ลาป่วย'
        ];
        $this->assertEquals($expected, $result);
    }

    public function testRunInsert()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read('leaveclass');
        $sql = $builder->buildPrepareInsert('leaveclass');
        $params = $builder->prepareInsertParams('leaveclass', $accessResult->fields);
        $insertStmt = $this->mysql->prepare($sql);

        $params[0] = 1000;
        $insertStmt->execute($params->toArray());

        $stmt = $this->mysql->query('SELECT * FROM leaveclass WHERE id = 1000');
        $result = $stmt->fetch();
        $expected = ['id' => '1000', 'leavename' => 'ลาป่วย', 0 => '1000', 1 => 'ลาป่วย'];
        $this->assertEquals($expected, $result);

        $this->mysql->exec('DELETE FROM leaveclass WHERE id = 1000');
    }

    public function testRunUpdate()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read('leaveclass');
        $sql = $builder->buildPrepareUpdate('leaveclass');
        $params = $builder->prepareUpdateParams('leaveclass', $accessResult->fields);
        $updateStmt = $this->mysql->prepare($sql);

        $params[1] = 'ลาหยุด';
        $updateStmt->execute($params->toArray());

        $stmt = $this->mysql->query('SELECT * FROM leaveclass WHERE id = 1');
        $result = $stmt->fetch();
        $expected = ['id' => '1', 'leavename' => 'ลาหยุด', 0 => '1', 1 => 'ลาหยุด'];
        $this->assertEquals($expected, $result);

        $this->mysql->exec('UPDATE leaveclass SET leavename = "ลาป่วย" WHERE id = 1');
    }
}
