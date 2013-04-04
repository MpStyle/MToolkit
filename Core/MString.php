<?php

namespace MToolkit\Core;

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

require_once dirname(__FILE__) . '/Enum/CaseSensitivity.php';
require_once dirname(__FILE__) . '/Exception/MWrongTypeException.php';

use MToolkit\Core\Enum\CaseSensitivity;
use MToolkit\Core\Exception\MWrongTypeException;

/**
 * The MString class provides a php string. 
 */
class MString
{

    /**
     * @var string
     */
    private $text = "";

    /**
     * 
     * @param MString|string $text
     * @throws MWrongTypeException
     */
    public function __construct($text = "")
    {
        $this->text = (string) $text;
    }

    /**
     * Appends the string <i>$text</i> onto the end of this string.
     * @param MString|string $text
     * @throws WrongTypeException 
     */
    public function append($str)
    {
        $string=(string)$str;

        return new MString( $this->text.$string );
    }

    public function __toString()
    {
        return (string) $this->text;
    }

    /**
     * Returns the character at the given <i>$i</i> position in the string.
     * The position must be a valid index position in the string (i.e., 0 <= position < size()).
     * @param int $i
     * @return string|null
     * @throws WrongTypeException 
     */
    public function at($i)
    {
        $result = substr($this->text, $i, 1);

        if ($result === false)
        {
            return null;
        }

        return $result;
    }

    /**
     * Removes <i>$n</i> characters from the end of the string.
     * If <i>$n</i> is greater than size(), the result is an empty string.
     * 
     * @param int $n
     * @throws WrongTypeException 
     */
    public function chop($n)
    {
        if ($n >= $this->size())
        {
            $this->text = "";
            return;
        }

        $result = substr($this->text, $i, strlen($this->text) - $n);

        if ($result === true)
        {
            $this->text = $result;
        }
    }

    /**
     * Clears the contents of the string and makes it empty. 
     */
    public function clear()
    {
        $this->text = "";
    }

    /**
     * Compares this string with <i>$other</i> and returns an integer less than, 
     * equal to, or greater than zero if this string is less than, equal to, or greater than <i>$other</i>.
     * If <i>$cs</i> is Qt::CaseSensitive, the comparison is case sensitive; 
     * otherwise the comparison is case insensitive.
     * 
     * @param MString|string $other
     * @param CaseSensitivity $cs
     * @return int 
     */
    public function compare($other, $cs = CaseSensitivity::CaseSensitive)
    {
        $text = (string) $this->text;
        $o = (string) $other;

        switch ($cs)
        {
            case CaseSensitivity::CaseSensitive:

                break;
            case CaseSensitivity::CaseInsensitive:
                $o = strtolower($other);
                $text = strtolower($this->text);
                break;
            default:
                throw new MWrongTypeException("\$cs", "CaseSensitivity", $cs);
                break;
        }

        return strcmp($text, $o);
    }

    /**
     * Returns true if this string contains an occurrence of the string <i>$str</i>; otherwise returns false.
     * 
     * @param MString $str
     * @param CaseSensitivity $cs
     * @return type 
     */
    public function /* bool */ contains(MString $str, $cs = CaseSensitivity::CaseSensitive)
    {
        $text = (string) $this->text;
        $s = (string) $str;

        switch ($cs)
        {
            case CaseSensitivity::CaseSensitive:

                break;
            case CaseSensitivity::CaseInsensitive:
                $s = strtolower($other);
                $text = strtolower($this->text);
                break;
            default:
                throw new MWrongTypeException("\$cs", "CaseSensitivity", $cs);
                break;
        }

        $result = strpos($text, $s);

        return ( $result !== false );
    }

    /**
     * Returns the number of characters in this string.
     * The last character in the string is at position size() - 1. 
     * 
     * @return int 
     */
    public function size()
    {
        return strlen($this->text);
    }

    public function count()
    {
        return $this->size();
    }

    /**
     * Returns the index position of the first occurrence of the string str in this string, 
     * searching forward from index position from. Returns -1 if str is not found.
     * 
     * @param string|MString $str
     * @param int $from
     * @param CaseSensitivity $cs
     * @return int 
     */
    public function indexOf($str, $from = 0, $cs = CaseSensitivity::CaseInsensitive)
    {
        $toSearch = (string) $str;
        $pos = false;

        switch ($cs)
        {
            case CaseSensitivity::CaseInsensitive:
                $pos = stripos($this->text, $toSearch, $from);
                break;
            case CaseSensitivity::CaseSensitive:
                $pos = strpos($this->text, $toSearch, $from);
                break;
        }

        if ($pos === false)
        {
            return -1;
        }

        return $pos;
    }

    /**
     * Returns the index position of the last occurrence of the string str in this string, 
     * searching backward from index position from. If from is -1 (default), 
     * the search starts at the last character; if from is -2, at the next to last character and so on. Returns -1 if str is not found.
     * 
     * @param string|MString $str
     * @param int $from
     * @param CaseSensitivity $cs
     * @return int
     */
    public function lastIndexOf($str, $from = 0, $cs = CaseSensitivity::CaseInsensitive)
    {
        $toSearch = (string) $str;
        $pos = false;

        switch ($cs)
        {
            case CaseSensitivity::CaseInsensitive:
                $pos = strripos($this->text, $toSearch, $from);
                break;
            case CaseSensitivity::CaseSensitive:
                $pos = strrpos($this->text, $toSearch, $from);
                break;
        }

        if ($pos === false)
        {
            return -1;
        }

        return $pos;
    }

    /**
     * Inserts the string str at the given index position and returns a reference to this string.
     * 
     * @param int $position
     * @param string|MString $str
     * @return MString
     */
    public function insert($position, $str)
    {
        $string = (string) $str;

        $string = substr_replace($this->text, $string, $position, 0);

        return new MString($string);
    }

    /**
     * Returns a substring that contains the n leftmost characters of the string.
     * The entire string is returned if n is greater than size() or less than zero.
     * 
     * @param int $n
     * @return null|MString
     */
    public function left($n)
    {
        if ($n < 0 || $n > $this->size())
        {
            return new MString($this->text);
        }

        $result = substr($this->text, 0, $n);

        if ($result === false)
        {
            return null;
        }

        return new MString($result);
    }

    /**
     * Returns a substring that contains the n rightmost characters of the string.
     * The entire string is returned if n is greater than size() or less than zero.
     * 
     * @param int $n
     * @return MString|null
     */
    public function right($n)
    {
        if ($n < 0 || $n > $this->size())
        {
            return new MString($this->text);
        }

        $pos = $n * -1;
        $result = substr($this->text, $pos);
        
        if ($result === false)
        {
            return null;
        }

        return new MString($result);
    }

    /**
     * @param string|MString $string
     * @return bool
     */
    public static function isNullOrEmpty($string)
    {
        $str = (string) $string;

        return ( $str == null || $str == '' );
    }
    
    /**
     * Returns true if this string is null; otherwise returns false.
     * 
     * @return boolean
     */
    public function isNull()
    {
        return ( $this->text==null );
    }

    /**
     * Returns true if the string has no characters; otherwise returns false.
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        return ( $this->text=='' );
    }
    
    /**
     * Returns a string that contains <i>$n</i> characters of this string, 
     * starting at the specified <i>$position</i> index.<br />
     * <br />
     * Returns a null string if the position index exceeds the length of the string. 
     * If there are less than n characters available in the string starting at the given position, 
     * or if n is -1 (default), the function returns all characters that are available from the specified position.
     * 
     * @param int $position
     * @param int $n
     * @return null|MString
     */
    public function mid($position, $n = -1)
    {
        $str=null;
        
        if( $n==-1 )
        {
            $str=substr($this->text, $position);
        }
        else
        {
            $str=substr($this->text, $position, $n);
        }
        
        return new MString($str);
    }
    
    /**
     * Prepends the string <i>$str</i> to the beginning of this string and returns a reference to this string.
     * 
     * @param string|MString $str
     * @return MString
     */
    public function prepend( $str)
    {
        $string=(string)$str;
        
        $string=$string.$this->text;
        
        return new MString( $string );
    }
}

