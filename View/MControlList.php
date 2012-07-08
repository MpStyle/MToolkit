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
    private $parent=null;
    
    public function __construct( MControl $parent=null )
    {
        $this->controls=new MMap();
        $this->parent=$parent;
    }
    
    public function /* void */ add( $id, MControl $control )
    {
        $this->controls->insert( $id, $control );
        
        if( is_null( $this->parent ) === false )
        {
            $this->parent->addedControl( $control, $this->count()-1 );
        }
    }
    
    public function /* MList */ toList()
    {
        $list=new MList();
                
        $list->appendArray( array_values( $this->controls->__toArray() ) );
        
        return $list;
    }
    
    public function /* int */ count()
    {
        return $this->controls->count();
    }
    
    public function /* MControl */ &controlById( $id )
    {
        if( is_string($id)===false )
        {
            throw new WrongTypeException( "\$id", "string", gettype($id) );
        }
        
        // Search in this control
        $controlToReturn= $this->controls->value( $id, null );
        
        // If not found, search into children
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

