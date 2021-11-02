<?php

namespace Anurat\AttExport\Tests\Unit\Database;

use Anurat\AttExport\Database\MSAccess;
use Anurat\AttExport\Database\Mysql;
use Anurat\AttExport\Database\SQLBuilder;
use Anurat\AttExport\Tests\TestCase;

class SQLBuilderTest extends TestCase
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

    public function testBuilder()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $this->assertInstanceOf(SQLBuilder::class, $builder);
    }

    public function testBuildPrepareSelect()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $sql = $builder->buildPrepareSelect('leaveclass');
        $expected = 'SELECT * FROM leaveclass WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareSelect('departments');
        $expected = 'SELECT * FROM departments WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareSelect('holidays');
        $expected = 'SELECT * FROM holidays WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareSelect('userinfo');
        $expected = 'SELECT * FROM userinfo WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareSelect('checkinout');
        $expected = 'SELECT * FROM checkinout WHERE userid = ? AND checktime = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareSelect('user_speday');
        $expected = 'SELECT * FROM user_speday WHERE userid = ? AND date_started = ? AND leave_id = ?';
        $this->assertEquals($expected, $sql);
    }

    public function testBuildPrepareInsert()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $sql = $builder->buildPrepareInsert('leaveclass');
        $expected = 'INSERT INTO leaveclass (id, leavename) VALUES (?, ?)';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareInsert('departments');
        $expected = 'INSERT INTO departments (id, deptname, super_id) VALUES (?, ?, ?)';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareInsert('holidays');
        $expected = 'INSERT INTO holidays (id, holidayname, starttime) VALUES (?, ?, ?)';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareInsert('userinfo');
        $expected = 'INSERT INTO userinfo ';
        $expected .= '(id, badgenumber, ssn, name, title, date_hired, date_resigned, defaultdeptid)';
        $expected .= ' VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareInsert('checkinout');
        $expected = 'INSERT INTO checkinout (userid, checktime, verifycode) VALUES (?, ?, ?)';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareInsert('user_speday');
        $expected = 'INSERT INTO user_speday (userid, date_started, date_ended, leave_id, description, date_modified)';
        $expected .= ' VALUES (?, ?, ?, ?, ?, ?)';
        $this->assertEquals($expected, $sql);
    }

    public function testBuildPrepareUpdate()
    {
        $builder = new SQLBuilder($this->access, $this->mysql);

        $sql = $builder->buildPrepareUpdate('leaveclass');
        $expected = 'UPDATE leaveclass SET id = ?, leavename = ? WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareUpdate('departments');
        $expected = 'UPDATE departments SET id = ?, deptname = ?, super_id = ? WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareUpdate('holidays');
        $expected = 'UPDATE holidays SET id = ?, holidayname = ?, starttime = ? WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareUpdate('userinfo');
        $expected = 'UPDATE userinfo SET id = ?, badgenumber = ?, ssn = ?, name = ?, title = ?,';
        $expected .= ' date_hired = ?, date_resigned = ?, defaultdeptid = ? WHERE id = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareUpdate('checkinout');
        $expected = 'UPDATE checkinout SET userid = ?, checktime = ?, verifycode = ?';
        $expected .= ' WHERE userid = ? AND checktime = ?';
        $this->assertEquals($expected, $sql);

        $sql = $builder->buildPrepareUpdate('user_speday');
        $expected = 'UPDATE user_speday';
        $expected .= ' SET userid = ?, date_started = ?, date_ended = ?, leave_id = ?, description = ?,';
        $expected .= ' date_modified = ? WHERE userid = ? AND date_started = ? AND leave_id = ?';
        $this->assertEquals($expected, $sql);
    }
}
