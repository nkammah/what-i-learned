<?php

namespace Model;

require_once __DIR__.'/../Mapper.php';
require_once __DIR__.'/KnowledgeBit.php';

use Model\KnowledgeBit as KnowledgeBitModel;

class KnowledgeBitMapper
{
    private $_mapper;
    
    function __construct($mapper)
    {
        $this->_mapper = $mapper;
    }
    
    function get($id)
    {        
        $kbRecord = $this->_mapper->get(
                'whatilearned_knowledgebit',
                $id
                );

        if (is_null($kbRecord)) {
            return null;
        };
        return new KnowledgeBitModel($kbRecord);
    }
}