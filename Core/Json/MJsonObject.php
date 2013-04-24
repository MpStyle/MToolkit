<?php

namespace MToolkit\Core\Json;

interface MJsonObject
{

    /**
     * Returns a string rappresenting the json of the object.
     * 
     * @return array 
     */
    public abstract function toArray();

    /**
     * Sets the property of the class, using the <i>$json</i>.
     * 
     * @param array $json
     * @return MJsonObject 
     */
    public abstract static function fromArray(array $json);
}

