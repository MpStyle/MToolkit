<?php

class MOutOfBoundsException extends Exception
{
    public function __construct($code=-1, $previous=null) {
        parent::__construct( "Out of bound.", $code, $previous);
    }
}


