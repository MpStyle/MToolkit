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

require_once dirname( __FILE__ ) . '/MAbstractTemplate.php';
require_once dirname( __FILE__ ) . '/MList.php';

use \MToolkit\Core\MList;
use \MToolkit\Core\Exception\MWrongTypeException;
use \MToolkit\Core\MAbstractTemplate;

class MMap extends MAbstractTemplate implements \ArrayAccess
{
    /**
     * @var array
     */
    private $map = array();

    public function __construct( array $other = array() )
    {
        if( count($other)>0 )
        {
            $this->map = array_merge( $this->map, $other );
        }
    }

    //QMap ( const QMap<Key, T> & other )

    public function clear()
    {
        $this->map = array();
    }

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

    public function count()
    {
        return count( $this->map );
    }

    public function isEmpty()
    {
        return ( $this->count() == 0 );
    }

    public function erase( $pos )
    {
        if (is_int( $pos ) === false)
        {
            throw new MWrongTypeException( "\$pos", "int", $pos );
        }

        $keys = array_keys( $this->map );

        unset( $this->map[$keys[$pos]] );
    }

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

    public function getKey( $value, $defaultKey = null )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if (is_string( $defaultKey ) === false)
        {
            throw new MWrongTypeException( "\$defaultKey", "string", $defaultKey );
        }

        $key = array_search( $value, $this->map );

        if ($key === false && is_null( $defaultKey ) === false)
        {
            $key = $defaultKey;
        }

        return $key;
    }

    /**
     * Returns a list containing all the keys associated with value value in ascending order.
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

    public function remove( $key )
    {
        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        unset( $this->map[$key] );
        return 1;
    }

    public function size()
    {
        return $this->count();
    }

    //void	swap ( QMap<Key, T> & other )

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

    public function getUniqueKeys()
    {
        return $this->keys();
    }

    //QMap<Key, T> &	unite ( const QMap<Key, T> & other )
    //iterator	upperBound ( const Key & key )
    //const_iterator	upperBound ( const Key & key ) const

    public function getValue( /* string */ $key, /* mixed */ $defaultValue = null )
    {
        if ($this->isValidType( $defaultValue ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $defaultValue );
        }

        if (is_string( $key ) === false)
        {
            throw new MWrongTypeException( "\$key", "string", $key );
        }

        //var_dump( $this->map );
        //echo "<br /><br />";

        $value = $this->map[$key];

        if (is_null( $value ) === true)
        {
            $value = $defaultValue;
        }

        return $value;
    }

    public function getValues()
    {
        return array_values( $this->map );
    }

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

    //public function values ( $key )
    //bool	operator!= ( const QMap<Key, T> & other ) const
    //QMap<Key, T> &	operator= ( const QMap<Key, T> & other )
    //bool	operator== ( const QMap<Key, T> & other ) const
}

