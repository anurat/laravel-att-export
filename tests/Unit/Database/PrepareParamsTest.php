<?php

namespace Anurat\AttExport\Tests\Unit\Database;

use Anurat\AttExport\Database\MSAccess;
use Anurat\AttExport\Database\Mysql;
use Anurat\AttExport\Database\SQLBuilder;
use Anurat\AttExport\Tests\TestCase;

class PrepareParamsTest extends TestCase
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

    public function testPrepareSelect()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read('leaveclass');
        $params = $builder->prepareSelectParams('leaveclass', $accessResult->Fields);
        $expected = [1];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('departments');
        $params = $builder->prepareSelectParams('departments', $accessResult->Fields);
        $expected = [1];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('holidays');
        $params = $builder->prepareSelectParams('holidays', $accessResult->Fields);
        $expected = [1];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('userinfo');
        $params = $builder->prepareSelectParams('userinfo', $accessResult->Fields);
        $expected = [2];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('checkinout');
        $params = $builder->prepareSelectParams('checkinout', $accessResult->Fields);
        $expected = [2, '2021-01-05 08:54:21'];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('user_speday');
        $params = $builder->prepareSelectParams('user_speday', $accessResult->Fields);
        $expected = [2, '2021-01-04 09:00:00', 2];
        $this->assertEquals($expected, array_values($params->toArray()));
    }

    public function testPrepareInsert()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read('leaveclass');
        $params = $builder->prepareInsertParams('leaveclass', $accessResult->fields);
        $expected = [1, 'ลาป่วย'];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('departments');
        $params = $builder->prepareInsertParams('departments', $accessResult->fields);
        $expected = [1, 'OUR COMPANY', 0];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('holidays');
        $params = $builder->prepareInsertParams('holidays', $accessResult->fields);
        $expected = [1, 'วันเฉลิมพระชนมพรรษา 2549', '2006-12-05'];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('userinfo');
        $params = $builder->prepareInsertParams('userinfo', $accessResult->fields);
        $expected = [2, '11007', '11007', 'สนธยา สุภาการ', 'จนท.บริหารงานทั่วไป', '2006-11-30', null, 6];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('checkinout');
        $params = $builder->prepareInsertParams('checkinout', $accessResult->fields);
        $expected = [2, '2021-01-05 08:54:21', 5];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('user_speday');
        $params = $builder->prepareInsertParams('user_speday', $accessResult->fields);
        $expected = [2, '2021-01-04 09:00:00', '2021-01-04 17:00:00', 2, null, '2020-11-10 10:44:24'];
        $this->assertEquals($expected, $params->toArray());
    }

    public function testPrepareUpdate()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $accessResult = $this->access->read('leaveclass');
        $params = $builder->prepareUpdateParams('leaveclass', $accessResult->fields);
        $expected = [1, 'ลาป่วย', 1];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('departments');
        $params = $builder->prepareUpdateParams('departments', $accessResult->fields);
        $expected = [1, 'OUR COMPANY', 0, 1];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('holidays');
        $params = $builder->prepareUpdateParams('holidays', $accessResult->fields);
        $expected = [1, 'วันเฉลิมพระชนมพรรษา 2549', '2006-12-05', 1];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('userinfo');
        $params = $builder->prepareUpdateParams('userinfo', $accessResult->fields);
        $expected = [2, '11007', '11007', 'สนธยา สุภาการ', 'จนท.บริหารงานทั่วไป', '2006-11-30 14:47:40', null, 6, 2];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('checkinout');
        $params = $builder->prepareUpdateParams('checkinout', $accessResult->fields);
        $expected = [2, '2021-01-05 08:54:21', 5, 2, '2021-01-05 08:54:21'];
        $this->assertEquals($expected, $params->toArray());

        $accessResult = $this->access->read('user_speday');
        $params = $builder->prepareUpdateParams('user_speday', $accessResult->fields);
        $expected = [
            2,
            '2021-01-04 09:00:00',
            '2021-01-04 17:00:00',
            2,
            null,
            '2020-11-10 10:44:24',
            2,
            '2021-01-04 09:00:00',
            2
        ];
        $this->assertEquals($expected, $params->toArray());
    }
}
