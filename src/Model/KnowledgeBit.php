<?php

namespace Model;

class KnowledgeBit
{
    private $_record;
    
    function __construct($record)
    {
        $this->_record = $record;
    }

    function getId()
    {
        return $this->_record->getField('id');
    }
  
    function getTitle()
    {
        return $this->_record->getField('title');
    }
    
    function getDescription()
    {
        return $this->_record->getField('description');
    }
    
    function getCategory()
    {
        return $this->_record->getField('category');
    }
    
    function getUrl()
    {
        return $this->_record->getField('url');
    }
    
    function __toString()
    {
        return sprintf(
            "%s (%s)",
            $this->getTitle(),
            $this->getId()
        );
    }
}