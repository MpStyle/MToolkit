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

require_once 'MToolkit/Core/MObject.php';
require_once 'MToolkit/Core/MMap.php';
require_once 'MToolkit/View/MControlList.php';
require_once 'MToolkit/View/MAttributeList.php';
require_once 'MToolkit/Core/Exception/WrongTypeException.php';

abstract class MControl extends MObject
{
    public $children=null;
    public $attributes=null;
    private $id=null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->id="obj_".sha1( microtime() );
        
        $this->children=new MControlList();
        $this->attributes=new MAttributeList();
    }
    
    protected abstract function init();
    
    public function id()
    {
        return $this->id;
    }
    
    public function setId( /* string */ $id )
    {
        if( is_string( $id )===false )
        {
            throw new WrongTypeException( "\$id", "string", gettype($id) );
        }
        
        $this->id=$id;
    }
    
    public function render( &$output )
    {
        //echo "<br />MControl::render()";
        
        $controlList=$this->children->toList();
        
        for( $i=0; $i< $controlList->count(); $i++ )
        {
            $controlList->at( $i )->render( $output );
        }
    }
    
    public function controlById( $id )
    {
        if( is_string($id)===false )
        {
            throw new WrongTypeException( "\$text", "string", gettype($id) );
        }
        
        return $this->children->controlById( $id );
    }
}
