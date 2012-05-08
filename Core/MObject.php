<?php

class MObject
{
    private $properties=Array();
    
    public function /* void */ addProperty( $key, $value )
    {
        $this->properties[$key]=$value;
    }
    
    public function /* void */ addProperties( array $properties )
    {
        $this->properties=array_merge($this->properties, $properties);
    }
    
    public function /* int */ propertyCount()
    {
        return count( $this->properties );
    }
    
    public function /* void */ propertyByPos( $i )
    {
        $keys = key($this->properties);
        return $this->properties[ $keys[$i] ];
    }
    
    public function /* string */ propertyByKey( $key )
    {
        return $this->properties[ $key ];
    }
}

