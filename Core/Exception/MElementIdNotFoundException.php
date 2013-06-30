<?php
namespace MToolkit\Core\Exception;

class MElementIdNotFoundException extends \Exception
{
    public function __construct($fileName, $idElement) 
    {
        parent::__construct("The element with id '" . $idElement . "' was not founded in the file '" . $fileName . "'.");
    }
}
