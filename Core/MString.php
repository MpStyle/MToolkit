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
 * along with MToolkit.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

require_once 'MToolkit/Core/Enums/CaseSensitive.php';
require_once 'MToolkit/Core/Exception/WrongTypeException.php';

/**
 * The MString class provides a php string. 
 */
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
    
    /**
     * Appends the string <i>$text</i> onto the end of this string.
     * @param MString $text
     * @throws WrongTypeException 
     */
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
        return (string)$this->text;
    }
    
    /**
     * Returns the character at the given <i>$i</i> position in the string.
     * The position must be a valid index position in the string (i.e., 0 <= position < size()).
     * @param int $i
     * @return string or null
     * @throws WrongTypeException 
     */
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
    
    /**
     * Removes <i>$n</i> characters from the end of the string.
     * If <i>$n</i> is greater than size(), the result is an empty string.
     * @param int $n
     * @throws WrongTypeException 
     */
    public function /* void */ chop( $n )
    {
        if( is_int($n)===false )
        {
            throw new WrongTypeException( "\$n", "int", gettype($n) );
        }
    
        if( $n>=$this->size() )
        {
            $this->text="";
            return;
        }
        
        $result=substr($this->text, $i, strlen($this->text)-$n);
        
        if( $result===true )
        {
            $this->text=$result;
        }
    }
    
    /**
     * Clears the contents of the string and makes it empty. 
     */
    public function clear()
    {
        $this->text="";
    }
    
    /**
     * Compares this string with <i>$other</i> and returns an integer less than, 
     * equal to, or greater than zero if this string is less than, equal to, or greater than <i>$other</i>.
     * If <i>$cs</i> is Qt::CaseSensitive, the comparison is case sensitive; 
     * otherwise the comparison is case insensitive.
     * 
     * @param MString $other
     * @param type $cs
     * @return type 
     */
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
            default:
                throw new WrongTypeException( "\$cs", "CaseSensitivity", gettype($cs) );
                break;
        }
        
        return strcmp( $text, $o );
    }
    
    /**
     * Returns true if this string contains an occurrence of the string <i>$str</i>; otherwise returns false.
     * 
     * @param MString $str
     * @param type $cs
     * @return type 
     */
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
            default:
                throw new WrongTypeException( "\$cs", "CaseSensitivity", gettype($cs) );
                break;
        }
        
        $result=  strpos($text, $s);
        
        return ( $result!==false );
    }
    
    /**
     * Returns the number of characters in this string.
     * The last character in the string is at position size() - 1. 
     * 
     * @return int 
     */
    public /* int */ function size()
    {
        return strlen($this->text);
    }
}

