<?php

class MSqlQuery
{
    private $sql;
    private $bindedValues=array();
    
    public function __construct( $sql )
    {
        $this->sql=$sql;
    }
    
    public function prepare( $sql )
    {
        $this->sql=$sql;
    }
    
    public function bindValue( $placeHolder, $value )
    {
        $this->bindedValues[$placeHolder]=$value;
    }
    
    public function __toString()
    {
        foreach( $this->bindedValues as $key => $value )
        {
            $this->sql = str_replace($key, $value, $this->sql);
        }
        
        return $this->sql;
    }
}

