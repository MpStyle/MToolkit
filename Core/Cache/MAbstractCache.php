<?php
namespace MToolkit\Core\Cache;

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

require_once '../MObject.php';

use MToolkit\Core\MObject;

abstract class MAbstractCache extends MObject
{
    public function __construct( MObject $parent = null )
    {
        parent::__construct( $parent );
    }

    /**
     * Remove a single cache record.
     * 
     * @param string $key
     */
    public abstract function delete( $key );
    
    /**
     * Remove all cache records.
     */
    public abstract function flush();
    
    /**
     * Return the content of a cache record with <i>$key</i>.
     * 
     * @param string $key
     * @return string|null
     */
    public abstract function get( $key );
    
    /**
     * Store a <i>$value</i> in a cache record with <i>$key</i>.
     * It is possible to pass a timestamp (microseconds) for the expiration.
     * 
     * @param string $key
     * @param string $value
     * @param float $expired
     * @return bool
     */
    public abstract function set( $key, $value, $expired = -1 );
}


