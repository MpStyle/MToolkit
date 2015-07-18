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

/**
 * Allows the access to the query string parameters.
 */
class MGet extends MMap
{
    public function __construct(  )
    {   
        parent::__construct( filter_input_array(INPUT_GET) );
    }
    
    /**
     * Throws an exception, because the <i>$this</i> object is read-only.
     * 
     * @throws MReadOnlyObjectException
     */
    public function clear()
    {
        throw new MReadOnlyObjectException('MGet','clear()');
    }

    /**
     * Throws an exception, because the <i>$this</i> object is read-only.
     * 
     * @param string $pos
     * @throws MReadOnlyObjectException
     */
    public function erase( $pos )
    {
        throw new MReadOnlyObjectException('MGet','erase( $pos )');
    }

    /**
     * Throws an exception, because the <i>$this</i> object is read-only.
     * 
     * @param string $key
     * @param mixed $value
     * @throws MReadOnlyObjectException
     */
    public function insert( $key, $value )
    {
        throw new MReadOnlyObjectException('MGet','insert( $key, $value )');
    }

    /**
     * Throws an exception, because the <i>$this</i> object is read-only.
     * 
     * @param string $key
     * @throws MReadOnlyObjectException
     */
    public function remove( $key )
    {
        throw new MReadOnlyObjectException('MGet','remove( $key )');
    }

    /**
     * Throws an exception, because the <i>$this</i> object is read-only.
     * 
     * @param int|string|null $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        throw new MReadOnlyObjectException('MGet','offsetSet( $offset, $value )');
    }

    /**
     * Throws an exception, because the <i>$this</i> object is read-only.
     * 
     * @param int|string $offset
     */
    public function offsetUnset( $offset )
    {
        throw new MReadOnlyObjectException('MGet', 'offsetUnset( $offset )');
    }
    
    /**
     * Returns the value for a specific <i>$key</i>.<br />
     * If the <i>$key</i> is not set a <i>$defaultValue</i> will be returned.
     * 
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getValue( $key, $defaultValue = null )
    {
        return parent::getValue($key, $defaultValue);
    }
}

