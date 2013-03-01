<?php
namespace MToolkit\Core\Json;

abstract class MJsonObject
{
    /**
     * Return a string rappresenting the json of the object
     * @return string 
     */
    public abstract function toJson();
}


