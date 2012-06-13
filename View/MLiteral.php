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

require_once 'MToolkit/View/MControl.php';

class MLiteral extends MControl
{
    public function __construct( /* string */ $text="" )
    {
        parent::__construct();
        
        $this->setText( $text );
    }
    
    public function setText( $text )
    {
        if( is_string( $text )===false )
        {
            throw new WrongTypeException( "\$text", "string", gettype($text) );
        }
        
        $this->properties->insert( "text", $text );
    }
    
    public function text()
    {
        return $this->properties->value( "text", "" );
    }
    
    public function render( &$output )
    {
        $output.=$this->text();
    }

    protected function init()
    {
        
    }
}

