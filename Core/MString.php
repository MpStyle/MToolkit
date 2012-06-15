<?php

/*
 * This file is part of MToolkit.
 *
 * MToolkit is free software: you can redistribute it and/or modify
 * it under the terms of the LGNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MToolkit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * LGNU Lesser General Public License for more details.
 *
 * You should have received a copy of the LGNU Lesser General Public License
 * along with Nome-Programma.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

require_once 'MToolkit/Core/Enums/CaseSensitive.php';
require_once 'MToolkit/Core/Exception/WrongTypeException.php';

class MString
{
    private $text="";
    
    public function __construct( $text="" )
    {
        if( is_string($text)===false )
        {
            throw new WrongTypeException( "\$text", "string", gettype($text) );
        }
        
        $this->text=$text;
    }
    
    public function append( MString $text )
    {
        if( ($text instanceof MString)===false )
        {
            throw new WrongTypeException( "\$text", "MString", gettype($text) );
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
            throw new WrongTypeException( "\$i", "int", gettype($i) );
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
            throw new WrongTypeException( "\$n", "int", gettype($n) );
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

