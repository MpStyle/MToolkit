<?php

class MWrongTypeException extends InvalidArgumentException
{
    public function __construct( $varName, $typeRequired, $typeGiven, $code=0, $previous=null )
    {
        parent::__construct("Wrong type exception for $varName: $typeRequired required, " . $typeGiven . " given.", $code, $previous);
    }
}
