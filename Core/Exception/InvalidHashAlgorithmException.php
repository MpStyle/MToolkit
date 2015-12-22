<?php
namespace MToolkit\Core\Exception;

class InvalidHashAlgorithmException extends \Exception
{
    public function __construct($hashAlgorithm, $code=-1, \Exception $previous=null)
    {
        parent::__construct(sprintf('Algorithm %s not supported.', $hashAlgorithm), $code, $previous);
    }
}