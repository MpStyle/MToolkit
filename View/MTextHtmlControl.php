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

class MTextHtmlControl extends MControl
{
    private $value=null;
    
    public function __construct( $value )
    {
        parent::__construct();
        
        $this->value=$value;
    }
    
    public function render( &$output )
    {
        $output.=$this->value;
    }

    protected function init()
    {
        
    }
}

