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

require_once __DIR__.'/MMap.php';
require_once __DIR__.'/Exception/MReadOnlyObjectException.php';

use MToolkit\Core\MMap;
use MToolkit\Core\Exception\MReadOnlyObjectException;

class MGet extends MMap
{
    public function __construct(  )
    {
        parent::__construct( $_GET );
    }
    
    public function clear()
    {
        throw new MReadOnlyObjectException('MGet','clear()');
    }

    public function erase( $pos )
    {
        throw new MReadOnlyObjectException('MGet','erase( $pos )');
    }

    public function insert( $key, $value )
    {
        throw new MReadOnlyObjectException('MGet','insert( $key, $value )');
    }

    public function remove( $key )
    {
        throw new MReadOnlyObjectException('MGet','remove( $key )');
    }

    /**
     * @param int|string|null $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        throw new MReadOnlyObjectException('MGet','offsetSet( $offset, $value )');
    }

    /**
     * @param int|string $offset
     */
    public function offsetUnset( $offset )
    {
        throw new MReadOnlyObjectException('MGet', 'offsetUnset( $offset )');
    }
    
    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getValue( $key, $defaultValue = null )
    {
        if( isset( $_GET[$key] )===false )
        {
            return $defaultValue;
        }
        
        return parent::getValue($key, $defaultValue);
    }
}

