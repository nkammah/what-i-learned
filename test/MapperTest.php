<?php

require_once __dir__ . '/../src/Mapper.php';
require_once  __dir__ . '/../src/Record.php';
require_once  __dir__ . '/../src/Testing/DBUnit/TestCase.php';
require_once 'PHPUnit/Extensions/Database/DataSet/ArrayDataSet.php';


use Testing\DBUnit\TestCase as DBUnitTestCase;

class MapperTest extends DBUnitTestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->mapper = new Mapper($this->getPDO());
    }

    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(
            array(
                'whatilearned_knowledgebit' => array(
                    array(
                        'id' => 1,
                        'title' => 'Simple Knowledge bit',
                        ),
                    array(
                        'id' => 2,
                        'title' => 'Complete Knowledge bit',
                        'description' => 'Hello world!',
                        'category' => 'general',
                        'url' => 'http://mydomain.com',
                        'date_added' => 1347565773
                        )
                )
            )
        );
    }
    
    public function testGetRecordExists()
    {
        $expected = new Record(
            $this->getPdo(),
            'whatilearned_knowledgebit',
            array(
                'id' => '1', 
                'title' => 'Simple Knowledge bit',
                'description' => null,
                'category' => null,
                'url' => null,
                'date_added' => null)
        );
        
        $actual = $this->mapper->get('whatilearned_knowledgebit', 1);
    
        $this->assertEquals($expected, $actual);
    }
    
    public function testGetRecordDoesNotExist()
    {
        $expected = null;
        $actual = $this->mapper->get('whatilearned_knowledgebit', 3);
    
        $this->assertEquals($expected, $actual);
    }
    
    public function testGetNewRecord()
    {
        $this->assertInstanceOf(
            'Record',
            $this->mapper->create('whatilearned_knowledgebit')
        );
    }
}
