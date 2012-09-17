<?php

namespace Testing\DBUnit;

use PDO;
use PHPUnit_Extensions_Database_TestCase;

abstract class TestCase extends PHPUnit_Extensions_Database_TestCase
{

    private static $_pdo;

    public static function setUpBeforeClass()
    {
        self::$_pdo = new PDO('sqlite::memory:');

        self::$_pdo->exec(
            '
            CREATE TABLE whatilearned_knowledgebit(
                id unsigned INTEGER PRIMARY KEY,
                title varchar(50) NOT NULL,
                description varchar(50),
                category varchar(100),
                url text,
                date_added datetime
                ) 
            '
        );
    }

    protected function getPDO()
    {
        return self::$_pdo;
    }

    protected function getConnection()
    {
        return $this->createDefaultDBConnection(self::$_pdo, ':memory:');
    }

}
