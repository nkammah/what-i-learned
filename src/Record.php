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
        $dirty_fields = array()
    )
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
        
        if (isset($this->_cleanFields[$field])) {
            return $this->_cleanFields[$field];
        };
        
        return null;     
    }
    
    function setField($field, $value)
    {
        if ($field == 'id') {
            throw new InvalidArgumentException(
                'You can\'t set the ID field'
            );
        };
        
        $this->_dirtyFields[$field] = $value;
        
        return true;     
    }
    
    
    function save()
    {
        // no changes
        if (empty($this->_dirtyFields)) {
            return false;
        }
        
        // check if new object or update
        if (isset($this->_cleanFields['id'])) {
            $sql = sprintf("UPDATE %s SET ", $this->_tableName);
            $values = array();
            foreach ($this->_dirtyFields as $k=>$v) {
                $values[] = sprintf("%s = '%s'", $k, $v);
            };
            $sql .= implode(',', $values);
            $sql .= sprintf(" where id=%s", $this->_cleanFields['id']);
        } else {
            $sql  = sprintf(
                'INSERT INTO %s (%s) values (%s)',
                $this->_tableName,
                implode(',', array_keys($this->_dirtyFields)),
                implode(
                    ',',
                    array_map(
                        function ($v) {
                            return "'$v'";
                        },
                        array_values($this->_dirtyFields)
                    )
                )
            );
        };
        
        $this->_pdo->query($sql);
        
        // Save the ID
        $this->_cleanFields['id'] = $this->_pdo->lastInsertId();
        
        // Save new fields
        $this->_cleanFields = array_merge(
            $this->_cleanFields,
            $this->_dirtyFields
        );
        
        // Clear the dirty fields
        $this->_dirtyFields = array();
        
        return true;
    }
}