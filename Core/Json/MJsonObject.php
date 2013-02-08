<?php
namespace MToolkit\Core\Json;

abstract class MJsonObject
{
    /**
     * Return a string rappresenting the json of the object
     * @return string 
     */
    public abstract function toJson();
    
    /**
     * Initialize the property of class with the content of the json
     * @param string $jsonString
     */
    public abstract function fromJson( $jsonString );
}


