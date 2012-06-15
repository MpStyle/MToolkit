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
require_once "MToolkit/Core/MList.php";
require_once 'MToolkit/Core/Exception/WrongTypeException.php';

class MControlList
{
    private $controls=null;
    
    public function __construct()
    {
        $this->controls=new MMap();
    }
    
    public function add( $id, MControl $control )
    {
        $this->controls->insert( $id, $control );
    }
    
    public function toList()
    {
        $list=new MList();
                
        $list->appendArray( array_values( $this->controls->__toArray() ) );
        
        return $list;
    }
    
    public function /* int */ count()
    {
        //return count( $this->controls );
        return $this->controls->count();
    }
    
//    public function /* MControl */ controlByPos( $i )
//    {
//        if( $i>=$this->controlCount() )
//        {
//            throw new Exception("Out of bound.");
//        }
//
//        $keys = array_keys($this->controls);
//
//        return $this->controls[ $keys[$i] ];
//    }
    
    public function /* MControl */ controlById( $id )
    {
        if( is_string($id)===false )
        {
            throw new WrongTypeException( "\$id", "string", gettype($id) );
        }
        
        $controlToReturn= $this->controls->value( $id, null );
        
        if( is_null( $controlToReturn ) )
        {
            $controls = $this->controls->__toArray();

            foreach( $controls as $idControl => $control )
            {
                $controlToReturn=$control->controlById( $id );
                
                if( is_null( $controlToReturn )!==true )
                {
                    return $controlToReturn;
                }
            }
        }
        
        return $controlToReturn;
    }

    
}

