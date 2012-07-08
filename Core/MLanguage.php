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

class MLanguage
{
    private $strings=array();
    private $lang=null;
    private $defaultLang=null;
    
    public function construct( $languagesFilePath )
    {
        if( is_string( $languagesFilePath )===false )
        {
            throw new WrongTypeException( "\$languagesFilePath", "string", gettype($languagesFilePath) );
        }
        
        if( file_exists($languagesFilePath)===false )
        {
            throw new Exception( "The file of languages not found at this location \"$languagesFilePath\"." );
        }
        
        $fileContent= file_get_contents($languagesFilePath);
        $this->strings=json_decode($fileContent,true);
    }
    
    public function /* string */ setDefaultLang( $lang )
    {
        if( is_string( $lang )===false )
        {
            throw new WrongTypeException( "\$lang", "string", gettype($lang) );
        }
        
        $this->defaultLang=$lang;
    }
    
    public function /* string */ defaultLang()
    {
        return $this->defaultLang;
    }
    
    public function /* string */ setLang( $lang )
    {
        if( is_string( $lang )===false )
        {
            throw new WrongTypeException( "\$lang", "string", gettype($lang) );
        }
        
        $this->lang=$lang;
    }
    
    public function /* string */ lang()
    {
        return $this->lang;
    }
    
    public function string( $key )
    {
        if( in_array($key, $this->strings[ $this->lang() ] )===true )
        {
            return $this->strings[ $this->lang() ][ $key ];
        }
        
        return $this->strings[ $this->defaultLang() ][ $key ];
    }
}

?>
