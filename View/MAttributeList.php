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

require_once "MToolkit/Core/MMap.php";
require_once 'MToolkit/Core/Exception/WrongTypeException.php';

class MAttributeList
{
    private $attributes=null;
    
    public function __construct()
    {
        $this->attributes=new MMap();
    }
    
    public function /* void */ add( $key, $value )
    {
        if( is_string($key)===false )
        {
            throw new WrongTypeException( "\$key", "string", gettype($key) );
        }
        
        if( is_string($value)===false )
        {
            throw new WrongTypeException( "\$value", "string", gettype($value) );
        }
        
        $this->attributes->insert( $key, $value );
    }
    
    public function /* int */ count()
    {
        return $this->attributes->count();
    }
    
    public function __toArray()
    {
        return $this->attributes->__toArray();
    }
    
//    
//    public function /* void */ addAttribute( $key, $value )
//    {
//        $this->attributes[$key]=$value;
//    }
//    
//    public function /* void */ setAttribute( $key, $value )
//    {
//        if( array_key_exists( $key, $this->attributes )===false )
//        {
//            throw new Exception("Attribute does not exists.");
//        }
//        
//        $this->attributes[$key]=$value;
//    }
//    
//    public function /* void */ addAttributes( array $attributes )
//    {
//        $this->attributes=array_merge($this->attributes, $attributes);
//    }
//    
//    public function /* int */ attributeCount()
//    {
//        return count( $this->attributes );
//    }
//    
//    public function /* void */ attributeByPos( $i )
//    {
//        $keys = key($this->attributes);
//        return $this->attributes[ $keys[$i] ];
//    }
//    
//    public function /* string */ attributeByKey( $key )
//    {
//        return $this->attributes[ $key ];
//    }
}
