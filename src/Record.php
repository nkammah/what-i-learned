<?php

class Record
{
    private $_pdo;
    private $_tableName;
    private $_cleanFields;
    private $_dirtyFields;
    
    function __construct(
        $pdo,
        $table_name,
        $clean_fields = array(),
        $dirty_fields = array())
    {
        $this->_pdo = $pdo;
        $this->_tableName = $table_name;
        $this->_cleanFields = $clean_fields;
        $this->_dirtyFields = $dirty_fields;
        
    }
    
    function getField($field)
    {
        if (isset($this->_dirtyFields[$field])) {
            return $this->_dirtyFields[$field];
        };
        
        if (isset($this->_cleanFields[$field]) ){
            return $this->_cleanFields[$field];
        };
        
        return null;     
    }
    
}