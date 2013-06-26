<?php
namespace MToolkit\Core\Exception;

class ReadOnlyObjectException extends \Exception
{
    public function __construct($className, $methodName) 
    {
        parent::__construct("The instance of " . $className . " is read-only. You can not use the method " . $methodName . ".");
    }
}
