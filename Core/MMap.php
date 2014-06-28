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

require_once __DIR__ . '/MAbstractTemplate.php';
require_once __DIR__ . '/MList.php';
require_once __DIR__ . '/MDataType.php';

use \MToolkit\Core\MList;
use \MToolkit\Core\Exception\MWrongTypeException;
use \MToolkit\Core\MAbstractTemplate;
use MToolkit\Core\MDataType;

class MMap extends MAbstractTemplate implements \ArrayAccess, \Iterator
{
    /**
     * @var array
     */
    private $map = array();
    
    /**
     * @var integer
     */
    private $pos = 0;

    /**
     * Constructs an object with an array <i>$other</i>.
     * 
     * @param array $other
     */
    public function __construct( array $other = array() )
    {
        if( count($other)>0 )
        {
            $this->map = array_merge( $this->map, $other );
        }
    }

    //QMap ( const QMap<Key, T> & other )

    /**
     * Removes all items from the map.
     */
    public function clear()
    {
        $this->map = array();
    }

    /**
     * Returns true if the map contains an item with key <i>$key</i>; otherwise 
     * returns false.
     * 
     * @param string $key
     * @return boolean
     * @throws MWrongTypeException
     */
    public function contains( $key )
    {
        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        $founded = array_key_exists( $key, $this->map );

        return ( $founded !== false );
    }

    //int count ( const Key & key ) const

    /**
     * Returns the number of items associated with key key.
     * 
     * @return int
     */
    public function count()
    {
        return count( $this->map );
    }

    /**
     * Returns true if the map contains no items; otherwise returns false.
     * 
     * @return int
     */
    public function isEmpty()
    {
        return ( $this->count() == 0 );
    }

    /**
     * Removes the (key, value) pair pointed to by the iterator pos from the 
     * map, and returns an iterator to the next item in the map.
     * 
     * @param string $pos
     * @throws MWrongTypeException
     */
    public function erase( $pos )
    {
        if (is_int( $pos ) === false)
        {
            throw new MWrongTypeException( "\$pos", "int", $pos );
        }

        $keys = array_keys( $this->map );

        unset( $this->map[$keys[$pos]] );
    }

    /**
     * Returns the value to the item with key <i>$key</i> in the map.
     * 
     * @param string $key
     * @return mixed
     * @throws MWrongTypeException
     */
    public function find( $key )
    {
        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        $founded = array_key_exists( $key, $this->map );

        if ($founded === false)
        {
            return null;
        }

        return $this->map[$key];
    }

    /**
     * Inserts a new item with the key <i>$key</i> and a value of <i>$value</i>.<br />
     * If there is already an item with the key <i>$key</i>, that item's value 
     * is replaced with <i>$value</i>.<br />
     * If there are multiple items with the key <i>$key</i>, the most recently 
     * inserted item's value is replaced with <i>$value</i>.<br />
     * 
     * @param string $key
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public function insert( $key, $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        $this->map[$key] = $value;
    }

    //iterator	insertMulti ( const Key & key, const T & value )

    /**
     * Returns the value associated with the key <i>$key</i>.
     * 
     * @param mixed $value
     * @param string $defaultKey
     * @return string
     * @throws MWrongTypeException
     */
    public function getKey( $value, $defaultKey = null )
    {        
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        MDataType::mustBeNullableString($defaultKey);

        $key = array_search( $value, $this->map );

        if ($key === false && is_null( $defaultKey ) === false)
        {
            $key = $defaultKey;
        }

        return $key;
    }

    /**
     * Returns a list containing all the keys associated with value value in 
     * ascending order.
     * 
     * @return \MToolkit\Core\MList
     */
    public function getKeys()
    {
        $list = new MList();
        $list->appendArray( array_keys( $this->map ) );

        return $list;
    }

    //QList<Key>	keys ( const T & value ) const
    //iterator	lowerBound ( const Key & key )
    //const_iterator	lowerBound ( const Key & key ) const

    /**
     * Removes all the items that have the key <i>$key</i> from the map. Returns 
     * the number of items removed which is usually 1 but will be 0 if the key 
     * isn't in the map.
     * 
     * @param string $key
     * @return int
     * @throws MWrongTypeException
     */
    public function remove( $key )
    {
        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        unset( $this->map[$key] );
        return 1;
    }

    /**
     * Returns the number of (key, value) pairs in the map.
     * 
     * @return int
     */
    public function size()
    {
        return $this->count();
    }

    //void	swap ( QMap<Key, T> & other )

    /**
     * Returns the number of (key, value) pairs in the map.
     * 
     * @param type $key
     * @return type
     * @throws MWrongTypeException
     */
    public function take( $key )
    {
        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        $key = $this->value( $key );
        $this->remove( $key );
        return $key;
    }

    //std::map<Key, T>	toStdMap () const

    /**
     * Returns a list containing all the keys in the map in ascending order. 
     * 
     * @return array[string]
     */
    public function getUniqueKeys()
    {
        return $this->keys();
    }

    //QMap<Key, T> &	unite ( const QMap<Key, T> & other )
    //iterator	upperBound ( const Key & key )
    //const_iterator	upperBound ( const Key & key ) const

    /**
     * Returns the value associated with the key key.
     * 
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     * @throws MWrongTypeException
     */
    public function &getValue( /* string */ $key, /* mixed */ $defaultValue = null )
    {
        if ($this->isValidType( $defaultValue ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $defaultValue );
        }

        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        $value = $this->map[$key];

        if (is_null( $value ) === true)
        {
            $value = $defaultValue;
        }

        return $value;
    }

    /**
     * Returns a list containing all the values in the map, in ascending order 
     * of their keys. If a key is associated with multiple values, all of its 
     * values will be in the list, and not just the most recently inserted one.
     * 
     * @return array[mixed]
     */
    public function getValues()
    {
        return array_values( $this->map );
    }

    /**
     * All keys-values in array.
     * 
     * @return array
     */
    public function __toArray()
    {
        //$return = clone $this->map;

        return $this->map;
    }

    /**
     * Return if a key exists.
     * 
     * @param int|string $offset
     * @return bool
     */
    public function offsetExists( $offset )
    {
        return (array_key_exists( $offset, $this->map ) === true);
    }

    /**
     * @param int|string $offset
     * @return mixed
     */
    public function offsetGet( $offset )
    {
        if ($this->offsetExists( $offset ))
        {
            return $this->map[$offset];
        }

        return null;
    }

    /**
     * @param int|string|null $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        if ($offset == null)
        {
            $this->map[] = $value;
        }
        else
        {
            $this->map[$offset] = $value;
        }
    }

    /**
     * @param int|string $offset
     */
    public function offsetUnset( $offset )
    {
        if ($this->offsetExists( $offset ))
        {
            unset( $this->map[$offset] );
        }
    }

    public function current()
    {
        $keys = $this->getKeys();

        return $this->getValue( $keys->at( $this->pos ), null );
    }

    public function key()
    {
        $keys = $this->getKeys();

        return $keys->at( $this->pos );
    }

    public function next()
    {
        $this->pos++;
    }

    public function rewind()
    {
        $this->pos = 0;
    }

    public function valid()
    {
        $keys = $this->getKeys();

        return ( $this->pos >= 0 && $this->pos < $keys->count() );
    }
    
    //public function values ( $key )
    //bool	operator!= ( const QMap<Key, T> & other ) const
    //QMap<Key, T> &	operator= ( const QMap<Key, T> & other )
    //bool	operator== ( const QMap<Key, T> & other ) const
}

