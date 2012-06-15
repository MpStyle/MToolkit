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

class MStringBuilder
{
    private $text;
    
    public function __construct( $text="" )
    {
        $this->text=$text;
    }
    
    public function append( /* mixed */ $object )
    {
        $this->text.=(string)$object;
    }
    
    public function appendFormat()
    {
        $argc=func_num_args();
        $argv=  func_get_args();
        $text=$argv[0];
        
        for( $i=1; $i<$argc-1; $i++ )
        {
            $currentIndex=$i-1;
            $text=str_replace("{$currentIndex}", $argv[$i], $text);
        }
        
        $this->text.=(string)$text;
    }
    
    public function insert( /* int */ $position, /* mixed */ $object )
    {
        $pre=substr($this->text, 0, $position);
        $post=substr($this->text, $position, strlen($this->text)-$position);
        
        $this->text=$pre . (string)$object . $post;
    }
    
    public function length()
    {
        return strlen($this->text);
    }
    
    public function remove( /* int */ $startIndex, /* int */ $length )
    {
        $position=$startIndex+$length;
        $pre=substr($this->text, 0, $startIndex);
        $post=substr($this->text, $position, strlen($this->text)-$position);
        
        $this->text=$pre . $post;
    }
    
    public function replace( /* string */ $search, /* string */ $replace )
    {
        $this->text=  str_replace($search, $replace, $this->text);
    }
    
    public function __toString()
    {
        return $this->text;
    }
}

