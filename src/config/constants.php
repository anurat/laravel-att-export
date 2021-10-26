<?php

const MSACCESS_DRIVER = 'Microsoft Access Driver (*.mdb, *.accdb)';
const MSACCESS_DATABASE = 'D:\\shareDB\\ATT2007.MDB';
const MSACCESS_PASSWORD = '';
// const MSACCESS_TABLE_NAMES = ['userinfo', 'departments', 'holidays', 'leaveclass', 'checkinout', 'user_speday'];
const MSACCESS_TABLE_NAMES = [];

const MSACCESS_FIELDS = [
    'checkinout' => [
        ['name' => 'USERID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'CHECKTIME', 'type' => 'datetime', 'primaryKey' => true],
        ['name' => 'VERIFYCODE', 'type' => 'int'],
    ],
    'departments' => [
        ['name' => 'DEPTID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'DEPTNAME', 'type' => 'string'],
        ['name' => 'SUPDEPTID', 'type' => 'int'],
    ],
    'holidays' => [
        ['name' => 'HOLIDAYID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'HOLIDAYNAME', 'type' => 'string'],
        ['name' => 'STARTTIME', 'type' => 'date'],
    ],
    'leaveclass' => [
        ['name' => 'LEAVEID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'LEAVENAME', 'type' => 'string'],
    ],
    'userinfo' => [
        ['name' => 'USERID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'Badgenumber', 'type' => 'string'],
        ['name' => 'SSN', 'type' => 'string'],
        ['name' => 'Name', 'type' => 'string'],
        ['name' => 'TITLE', 'type' => 'string'],
        ['name' => 'HIREDDAY', 'type' => 'date'],
        ['name' => 'BIRTHDAY', 'type' => 'date'],
        ['name' => 'DEFAULTDEPTID', 'type' => 'int'],
    ],
    'user_speday' => [
        ['name' => 'USERID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'STARTSPECDAY', 'type' => 'datetime', 'primaryKey' => true],
        ['name' => 'ENDSPECDAY', 'type' => 'datetime'],
        ['name' => 'DATEID', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'YUANYING', 'type' => 'string'],
        ['name' => 'DATE', 'type' => 'datetime'],
    ],
];

const MYSQL_HOSTNAME = 'att2.rs.cri.or.th';
const MYSQL_USERNAME = 'dba';
const MYSQL_PASSWORD = '25ed8c4ad7';
const MYSQL_DATABASE = 'att';
const MYSQL_TABLE_NAMES = MSACCESS_TABLE_NAMES;
const MYSQL_FIELDS = [
    'checkinout' => [
        ['name' => 'userid', 'type' => 'string', 'primaryKey' => true],
        ['name' => 'checktime', 'type' => 'datetime', 'primaryKey' => true],
        ['name' => 'verifycode', 'type' => 'int'],
    ],
    'departments' => [
        ['name' => 'id', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'deptname', 'type' => 'string'],
        ['name' => 'super_id', 'type' => 'int'],
    ],
    'holidays' => [
        ['name' => 'id', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'holidayname', 'type' => 'string'],
        ['name' => 'starttime', 'type' => 'date'],
    ],
    'leaveclass' => [
        ['name' => 'id', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'leavename', 'type' => 'string'],
    ],
    'userinfo' => [
        ['name' => 'id', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'badgenumber', 'type' => 'string'],
        ['name' => 'ssn', 'type' => 'string'],
        ['name' => 'name', 'type' => 'string'],
        ['name' => 'title', 'type' => 'string'],
        ['name' => 'date_hired', 'type' => 'datetime'],
        ['name' => 'date_resigned', 'type' => 'datetime'],
        ['name' => 'defaultdeptid', 'type' => 'int'],
    ],
    'user_speday' => [
        ['name' => 'userid', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'date_started', 'type' => 'datetime', 'primaryKey' => true],
        ['name' => 'date_ended', 'type' => 'datetime'],
        ['name' => 'leave_id', 'type' => 'int', 'primaryKey' => true],
        ['name' => 'description', 'type' => 'string'],
        ['name' => 'date_modified', 'type' => 'datetime'],
    ],
];
