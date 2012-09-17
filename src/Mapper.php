<?php

require_once 'Record.php';

class Mapper
{
    private $_pdo;
    
    function __construct($pdo)
    {
        $this->_pdo = $pdo;
    }
    
    function create($table_name)
    {
        return new Record(
            $this->_pdo,
            $table_name
        );
    }

    function get($table_name, $id)
    {        
        $stmt = $this->_pdo->prepare(
            sprintf(
                "SELECT * from %s WHERE id = :id",
                $table_name
            )
        );
        
        $stmt->execute(array(':id' => $id));
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if ($row === false) {
            return null;
        } else {
            return new Record(
                $this->_pdo,
                $table_name,
                $row
            );
        }
    }

}