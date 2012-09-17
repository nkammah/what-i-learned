<?php

require_once  __dir__ . '/../src/Record.php';
require_once  __dir__ . '/../src/Testing/DBUnit/TestCase.php';
require_once 'PHPUnit/Extensions/Database/DataSet/ArrayDataSet.php';


use Testing\DBUnit\TestCase as DBUnitTestCase;

class RecordTest extends DBUnitTestCase
{
    
    protected function setUp()
    {
        parent::setUp();
        $this->record = new Record(
            $this->getPDO(),
            'whatilearned_knowledgebit',
            array(
                'id' => 1,
                'title' => 'Simple Knowledge bit'
            )
        );
        
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
    
    function testGetFieldNotModified()
    {
        $this->assertEquals(
            'Simple Knowledge bit',
            $this->record->getField('title')
        );
    }
    
    
    function testGetFieldNotSet()
    {   
        $this->assertNull(
            $this->record->getField('key')
        );
    }
    
    function testGetFieldModified()
    {
        $record = new Record(
            $this->getPdo(),
            'whatilearned_knowledgebit',
            array('key' => 'value'), 
            array('key' => 'new value')
        );
        
        $this->assertEquals(
            'new value',
            $record->getField('key')
        );        
    }
    
    function testGetFieldNewRecord()
    {
        $record = new Record(
            $this->getPdo(),
            'whatilearned_knowledgebit'
        );
        
        $this->assertNull(
            $record->getField('key')
        );
    }
    
    function testSetNewField()
    {
        $this->record->setField('name', 'Nassim');
        
        $this->assertEquals(
            'Nassim',
            $this->record->getField('name')
        );        
    }
    
    function testSetFieldAlreadyDefined()
    {
        $this->record->setField('key', 'new value');
        
        $this->assertEquals(
            'new value',
            $this->record->getField('key')
        );        
    }
    
    function testSetFieldDoesNotTouchDb()
    {        
        $expected = $this->getDataSet()
            ->getTable('whatilearned_knowledgebit');
                        
        $this->record->setField('key', 'value');
        
        $actual = $this->getConnection()
            ->createQueryTable(
                'whatilearned_knowledgebit',
                'SELECT * FROM whatilearned_knowledgebit'
            );
        $this->assertTablesEqual($expected, $actual);
    }
    
    
    /**
     *@expectedException InvalidArgumentException
     *@expectedExceptionMessage You can't set the ID field
     */
    function testSetIdField()
    {
        $this->record->setField('id', 3);
    }
    
    
    function testSaveNotModified()
    {
        $expected = $this->getDataSet()
            ->getTable('whatilearned_knowledgebit');
                         
        $this->record->save();

        $actual = $this->getConnection()
            ->createQueryTable(
                'whatilearned_knowledgebit',
                'SELECT * FROM whatilearned_knowledgebit'
            );
        $this->assertTablesEqual($expected, $actual);
    }

    function testSaveNewRecord()
    {
        $record = new Record(
            $this->getPdo(),
            'whatilearned_knowledgebit'
        );
                
        $record->setField('title', 'value');
        
        $record->save();
        
        $this->assertEquals(
            3,
            $this->getConnection()->getRowCount('whatilearned_knowledgebit')
        );
    }
    
    function testSaveModified()
    {
        $expected = new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(
            array(
                'whatilearned_knowledgebit' => array(
                    array(
                        'id' => 1,
                        'title' => 'Random Knowledge bit',
                        'description' => null,
                        'category' => null,
                        'url' =>  'http://myurl.com'
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
        
        $this->record->setField('title', 'Random Knowledge bit');
        
        $this->record->setField('url', 'http://myurl.com');
        

        $this->record->save();
        
        $actual = $this->getConnection()
            ->createQueryTable(
                'whatilearned_knowledgebit',
                'SELECT * FROM whatilearned_knowledgebit'
            );
                        
        $this->assertTablesEqual(
            $expected->getTable('whatilearned_knowledgebit'),
            $actual
        );
        
    }

}
