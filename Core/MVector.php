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

require_once __DIR__ . '/Exception/MWrongTypeException.php';
require_once __DIR__ . '/MAbstractTemplate.php';

use \MToolkit\Core\Exception\MWrongTypeException;
use \MToolkit\Core\MAbstractTemplate;

class MVector extends MAbstractTemplate implements \ArrayAccess
{
    /**
     * @var array
     */
    private $vector = array();

    public function __construct()
    {
        
    }

    /**
     * Inserts value at the end of the vector.
     * @param mixed $value 
     */
    public function append( $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        $this->vector[] = $value;
    }

    /**
     * Returns the item at index position <i>i</i> in the vector.
     * <i>i</i> must be a valid index position in the vector (i.e., 0 <= <i>i</i> < size()).
     * @param int $i
     * @return mixed
     * @throws MWrongTypeException If <i>i</i> is not a int.
     */
    public function at( $i )
    {
        if (is_int( $i ) === false)
        {
            throw new MWrongTypeException( "\$i", "int", $i );
        }

        if ($i >= $this->count())
        {
            return null;
        }

        return $this->vector[$i];
    }

    /**
     * Removes all the elements from the vector and releases the memory used by the vector. 
     */
    public function clear()
    {
        $this->vector = array();
    }

    /**
     * Returns true if the vector contains an occurrence of <i>value</i>; otherwise returns false.
     * @param mixed $value
     * @return bool 
     */
    public function contains( /* mixed */ $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        return in_array( $value, $this->vector );
    }

    //int count (  T & value ) 

    /**
     * If <i>value</i> is not null: returns the number of occurrences of value in the vector.
     * If <i>value</i> is null: same as size().
     * 
     * @param mixed $value
     * @return int 
     */
    public function count( $value = null )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if (is_null( $value ))
        {
            return count( $this->vector );
        }

        $occurrences = 0;
        foreach ( $this->vector as $item )
        {
            if ($item == $value)
            {
                $occurrences++;
            }
        }

        return $occurrences;
    }

    //T * data()
    // T * data () 

    /**
     * Returns true if the vector has size 0; otherwise returns false.
     * @return bool 
     */
    public function isEmpty()
    {
        return ( count( $this->vector ) == 0 );
    }

    public function /* bool */ endsWith( /* mixed */ $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        return ( $this->vector[$this->size() - 1] == $value );
    }

    //iterator erase ( iterator pos )
    //iterator erase ( iterator begin, iterator end )
    //QVector<T> & fill (  T & value, int size = -1 )
    public function first()
    {
        if (0 >= $this->count())
        {
            throw new OutOfBoundsException();
        }

        return $this->vector[0];
    }

    public function front()
    {
        return $this->first();
    }

    public function /* int */ indexOf( $value, $from = 0 )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if (is_int( $from ) === false)
        {
            throw new MWrongTypeException( "\$from", "int", $from );
        }

        $to = $this->count() - 1;

        if ($from == -1)
        {
            $to = $from;
        }

        for ( $i = 0; $i == $to; $i++ )
        {
            if ($this->vector[$i] == $value)
            {
                return $i;
            }
        }
    }

    //iterator insert ( iterator before, int count,  T & value )
    public function /* void */ insert( $i, /* mixed */ $value, $count = 1 )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if (is_int( $i ) === false)
        {
            throw new MWrongTypeException( "\$i", "int", gettype( $i ) );
        }

        if (is_int( $count ) === false)
        {
            throw new MWrongTypeException( "\$count", "int", $count );
        }

        for ( $j = 1; j <= $count; $j++ )
        {
            array_splice( $this->vector, $i, 0, $value );
        }
    }

    //iterator insert ( iterator before,  T & value ) 
    public function last()
    {
        if ($this->count() <= 0)
        {
            throw new OutOfBoundsException();
        }

        return $this->vector[$this->count() - 1];
    }

    public function /* int */ lastIndexOf( /* mixed */ $value, $from = -1 )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
    }

    //QVector<T> mid ( int pos, int length = -1 ) 
    public function /* void */ pop_back()
    {
        if ($this->count() <= 0)
        {
            throw new OutOfBoundsException();
        }

        $item = $this->vector[$this->count() - 1];

        $this->removeLast();

        return $item;
    }

    public function /* void */ pop_front()
    {
        if ($this->count() <= 0)
        {
            throw new OutOfBoundsException();
        }

        $item = $this->vector[0];

        $this->removeFirst();

        return $item;
    }

    public function /* void */ prepend( $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        array_unshift( $this->list, $value );
    }

    public function /* void */ push_back( $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        $this->list[] = $value;
    }

    public function /* void */ push_front( $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        $this->prepend( $value );
    }

    public function /* void */ remove( $i, $count = 1 )
    {
        if (is_int( $i ) === false)
        {
            throw new MWrongTypeException( "\$i", "int", $i );
        }

        for ( $j = 0; $j < $count; $j++ )
        {
            if (count( $this->vector ) >= $j)
            {
                throw new OutOfBoundsException();
            }

            unset( $this->vector[$j] );
        }
    }

    public function /* void */ replace( $i, $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if (is_int( $i ) === false)
        {
            throw new MWrongTypeException( "\$i", "int", gettype( $i ) );
        }

        if (count( $this->vector ) >= $i)
        {
            throw new OutOfBoundsException();
        }

        $this->vector[$i] = $value;
    }

    //public function /* void */ reserve ( $size ) 
    //{}
    //public function /* void */ resize ( $size ) 
    //{}

    public function /* int */ size()
    {
        return count( $this->vector );
    }

    //public function /* void */ squeeze () 
    //{}

    public function /* bool */ startsWith( $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        return ( $this->vector[0] == $value );
    }

    //public function /* void */ swap ( QVector<T> & other )            
    //QList<T> toList () 
    //std::vector<T> toStdVector () 

    public function getValue( /* int */ $i, /* mixed */ $defaultValue = null )
    {
        if ($this->isValidType( $defaultValue ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $defaultValue );
        }

        if (is_int( $i ) === false)
        {
            throw new MWrongTypeException( "\$i", "int", gettype( $i ) );
        }

        $value = $this->list[$i];

        if (is_null( $value ) === true && is_null( $defaultValue ) === false)
        {
            $value = $defaultValue;
        }

        return $value;
    }

    /**
     * Return if a key exists.
     * 
     * @param int|string $offset
     * @return bool
     */
    public function offsetExists( $offset )
    {
        return (array_key_exists( $offset, $this->vector ) === true);
    }

    /**
     * @param int|string $offset
     * @return mixed
     */
    public function offsetGet( $offset )
    {
        if ($this->offsetExists( $offset ))
        {
            return $this->vector[$offset];
        }

        return null;
    }

    /**
     * @param int|string|null $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        if ($this->isValidType( $value ) === false)
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }

        if ($offset == null)
        {
            $this->vector[] = $value;
        }
        else
        {
            $this->vector[$offset] = $value;
        }
    }

    /**
     * @param int|string $offset
     */
    public function offsetUnset( $offset )
    {
        if ($this->offsetExists( $offset ))
        {
            unset( $this->vector[$offset] );
        }
    }

    //bool operator!= (  QVector<T> & other ) 
    //QVector<T> operator+ (  QVector<T> & other ) 
    //QVector<T> & operator+= (  QVector<T> & other )
    //QVector<T> & operator+= (  T & value )
    //QVector<T> & operator<< (  T & value )
    //QVector<T> & operator<< (  QVector<T> & other )
    //QVector<T> & operator= (  QVector<T> & other )
    //bool operator== (  QVector<T> & other ) 
}

