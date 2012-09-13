<?php


require_once __DIR__ . '/Model/KnowledgeBitMapper.php';
require_once __DIR__ . '/Mapper.php';

use Model\KnowledgeBitMapper as KnowledgeBitMapper;

try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=test', 'devuser', 'devpwd');

    $mapper = new Mapper($dbh);

    $kbMapper = new KnowledgeBitMapper($mapper);
    
    $kbit = $kbMapper->get(1);

    if ($kbit) {
        print $kbit->getTitle();
    } else {
        print "Knowledge bit not found";
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}