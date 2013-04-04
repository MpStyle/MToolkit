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

abstract class MAbstractTemplate 
{
    /**
     * @var string
     */
    private $type = null;

    /**
     * @param string $type
     * @param \MToolkit\Core\MObject $parent
     */
    public function __construct( $type=null, MObject $parent = null )
    {
        parent::__construct( $parent );
        $this->type=$type;
    }

    public function isValidType( $object )
    {
        if ( $this->type==null || $object==null )
        {
            return true;
        }

        if ( is_object($object) && get_class( $object ) == $this->type )
        {
            return true;
        }
        
        return false;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
        return $this;
    }
}