<?php

namespace Testing\DBUnit;

use PDO;
use PHPUnit_Extensions_Database_TestCase;

abstract class TestCase extends PHPUnit_Extensions_Database_TestCase {

    private static $pdo;

    public static function setUpBeforeClass() {
        self::$pdo = new PDO('sqlite::memory:');

        self::$pdo->exec(
            '
            CREATE TABLE whatilearned_knowledgebit(
                id unsigned NOT NULL PRIMARY KEY,
                title varchar(50) NOT NULL,
                description varchar(50),
                category varchar(100),
                url text,
                date_added datetime
                ) 
            '
        );
    }

    protected function getPDO() {
        return self::$pdo;
    }

    protected function getConnection() {
        return $this->createDefaultDBConnection(self::$pdo, ':memory:');
    }
}
