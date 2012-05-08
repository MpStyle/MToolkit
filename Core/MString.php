<?php

require_once 'MToolkit/Core/Enum/CaseSensitive.php';

class MString
{
    private $text="";
    
    public function __construct( $text="" )
    {
        if( is_string($text)===false )
        {
            throw new MWrongTypeException( "\$text", "string", gettype($text) );
        }
        
        $this->text=$text;
    }
    
    public function append( MString $text )
    {
        if( ($text instanceof MString)===false )
        {
            throw new MWrongTypeException( "\$text", "MString", gettype($text) );
        }
        
        $this->text=(string)$text;
    }
    
    public function __toString()
    {
        return $this->text;
    }
    
    public /* string */ function at( $i )
    {
        if( is_int($i)===false )
        {
            throw new MWrongTypeException( "\$i", "int", gettype($i) );
        }
        
        $result=substr($this->text, $i, 1);
        
        if( $result===false )
        {
            return null;
        }
        
        return $result;
    }
    
    public function /* void */ chop( $n )
    {
        if( is_int($n)===false )
        {
            throw new MWrongTypeException( "\$n", "int", gettype($n) );
        }
        
        $result=substr($this->text, $i, strlen($this->text)-$n);
        
        if( $result===true )
        {
            $this->text=$result;
        }
    }
    
    public function clear()
    {
        $this->text="";
    }
    
    public function /* int */ compare( MString $other, $cs=CaseSensitivity::CaseSensitive )
    {
        $text=(string)$this->text;
        $o=(string)$other;
        
        switch( $cs )
        {
            case CaseSensitivity::CaseSensitive:
                
                break;
            case CaseSensitivity::CaseInsensitive:
                $o=strtolower( $other );
                $text=strtolower( $this->text );
                break;
        }
        
        return strcmp( $text, $o );
    }
    
    public function /* bool */ contains( MString $str, $cs = CaseSensitivity::CaseSensitive )
    {
        $text=(string)$this->text;
        $s=(string)$str;
        
        switch( $cs )
        {
            case CaseSensitivity::CaseSensitive:
                
                break;
            case CaseSensitivity::CaseInsensitive:
                $s=strtolower( $other );
                $text=strtolower( $this->text );
                break;
        }
        
        $result=  strpos($text, $s);
        
        return ( $result!==false );
    }
    
    public function size()
    {
        return strlen($this->text);
    }
}

