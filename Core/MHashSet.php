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

require_once 'MObject.php';
require_once 'MHashSetIterator.php';

use MToolkit\Core\MObject;
use MToolkit\Core\MHashSetIterator;

class MHashSet implements \ArrayAccess
{
    private $hashSet = array();

    /**
     * Adds the specified element to this set if it is not already present.
     * @param mixed $e
     * @return bool
     */
    public function add( $e )
    {
        $exists = false;

        foreach( $this->hashSet as $set )
        {
            $exists = $exists || MObject::areEquals( $set, $e );
        }
        
        if( $exists!==false )
        {
            $this->hashSet[]=$e;
        }
        
        return $exists;
    }

    /**
     * Removes all of the elements from this set.
     */
    public function clear()
    {
        $this->hashSet = array();
    }

    /**
     * Returns true if this set contains the specified element.
     * 
     * @param mixed $o
     * @return bool
     */
    public function contains( $o )
    {
        $exists = false;

        foreach( $this->hashSet as $set )
        {
            $exists = $exists || MObject::areEquals( $set, $o );
        }
        
        return $exists;
    }

    /**
     * Returns true if this set contains no elements.
     * 
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this->hashSet)==0);
    }

    public function iterator()
    {
        return new MHashSetIterator($this);
    }

// Returns an iterator over the elements in this set.

    /**
     * Removes the specified element from this set if it is present.
     * 
     * @param mixed $o
     */
    public function remove( $o )
    {
        for( $i=0; $i<count($this->hashSet); $i++ )
        {
            if( MObject::areEquals( $this->hashSet[$i], $o )===true)
            {
                unset( $this->hashSet[$i] );
            }
        }
    }

    /**
     * Returns the number of elements in this set (its cardinality).
     * 
     * @return int
     */
    public function size()
    {
        return count($this->hashSet);
    }

    public function offsetExists( $offset )
    {
        return (array_key_exists( $offset, $this->hashSet ) === true);
    }

    public function offsetGet( $offset )
    {
        if ($this->offsetExists( $offset ))
        {
            return $this->hashSet[$offset];
        }

        return null;
    }

    public function offsetSet( $offset, $value )
    {
        if ($offset == null)
        {
            $this->hashSet[] = $value;
        }
        else
        {
            $this->hashSet[$offset] = $value;
        }
    }

    public function offsetUnset( $offset )
    {
        if ($this->offsetExists( $offset ))
        {
            unset( $this->hashSet[$offset] );
        }
    }
}