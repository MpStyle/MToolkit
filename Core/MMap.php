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

require_once dirname( __FILE__ ) . '/Exception/MWrongTypeException.php';
require_once dirname( __FILE__ ) . '/MList.php';

use \MToolkit\Core\MList;
use \MToolkit\Core\Exception\MWrongTypeException;

class MMap
{

    /**
     * @var array
     */
    private $map = array( );

    public function __construct( array $other = array( ) )
    {
        $this->map = array_merge( $this->map, $other );
    }

    //QMap ( const QMap<Key, T> & other )

    public function clear()
    {
        $this->map = array( );
    }

    public function contains( $key )
    {
        if( is_string( $key ) === false )
        {
            throw new WrongTypeException( "\$key", "string", gettype( $key ) );
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
        if( is_int( $pos ) === false )
        {
            throw new WrongTypeException( "\$pos", "int", gettype( $pos ) );
        }

        $keys = array_keys( $this->map );

        unset( $this->map[$keys[$pos]] );
    }

    public function find( $key )
    {
        if( is_string( $key ) === false )
        {
            throw new WrongTypeException( "\$key", "string", gettype( $key ) );
        }

        $founded = array_key_exists( $key, $this->map );

        if( $founded === false )
        {
            return null;
        }

        return $this->map[$key];
    }

    public function insert( $key, $value )
    {
        if( is_string( $key ) === false )
        {
            throw new WrongTypeException( "\$key", "string", gettype( $key ) );
        }

        $this->map[$key] = $value;
    }

    //iterator	insertMulti ( const Key & key, const T & value )

    public function getKey( $value, $defaultKey = null )
    {
        if( is_string( $defaultKey ) === false )
        {
            throw new WrongTypeException( "\$defaultKey", "string", gettype( $defaultKey ) );
        }

        $key = array_search( $value, $this->map );

        if( $key === false && is_null( $defaultKey ) === false )
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
        if( is_string( $key ) === false )
        {
            throw new WrongTypeException( "\$key", "string", gettype( $key ) );
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
        if( is_string( $key ) === false )
        {
            throw new WrongTypeException( "\$key", "string", gettype( $key ) );
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
        if( is_string( $key ) === false )
        {
            throw new WrongTypeException( "\$key", "string", gettype( $key ) );
        }

        //var_dump( $this->map );
        //echo "<br /><br />";

        $value = $this->map[$key];

        if( is_null( $value ) === true )
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

    //public function values ( $key )
    //bool	operator!= ( const QMap<Key, T> & other ) const
    //QMap<Key, T> &	operator= ( const QMap<Key, T> & other )
    //bool	operator== ( const QMap<Key, T> & other ) const
    //T &	operator[] ( const Key & key )
    //const T	operator[] ( const Key & key ) const

}

class MMapIterator extends \Iterator
{

    /**
     * @var MMap
     */
    private $map;

    /**
     * @var integer
     */
    private $pos = 0;

    public function __constructor( MList $map )
    {
        $this->map = $map;
    }

    public function current()
    {
        $keys = $this->map->getKeys();

        return $this->map->value( $keys->at( $this->pos ), null );
    }

    public function key()
    {
        $keys = $this->map->getKeys();

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
        $keys = $this->map->getKeys();

        return ( $this->pos >= 0 && $this->pos < $keys->count() );
    }

}
