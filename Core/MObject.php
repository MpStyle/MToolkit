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
 * @version 0.01
 */

class MObject
{
    private $properties=Array();
    
    public function /* void */ addProperty( $key, $value )
    {
        $this->properties[$key]=$value;
    }
    
    public function /* void */ addProperties( array $properties )
    {
        $this->properties=array_merge($this->properties, $properties);
    }
    
    public function /* int */ propertyCount()
    {
        return count( $this->properties );
    }
    
    public function /* void */ propertyByPos( $i )
    {
        $keys = key($this->properties);
        return $this->properties[ $keys[$i] ];
    }
    
    public function /* string */ propertyByKey( $key )
    {
        return $this->properties[ $key ];
    }
}

