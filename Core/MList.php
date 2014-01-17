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

require_once __DIR__.'/MAbstractTemplate.php';
require_once __DIR__.'/Exception/MWrongTypeException.php';
require_once __DIR__ . '/MDataType.php';

use \MToolkit\Core\Exception\MWrongTypeException;
use \MToolkit\Core\MAbstractTemplate;
use MToolkit\Core\MDataType;

/**
 * The MList class is a template class that provides lists.<br />
 * It provides accessing objects as arrays.
 */
class MList extends MAbstractTemplate implements \ArrayAccess
{
    /**
     * @var array
     */
    private $list = array( );

    /**
     * Constructs a list with the values of <i>$list</i>.
     * 
     * @param \MToolkit\Core\MList $list
     */
    public function __construct( array $list = array(), $type=null, MObject $parent = null )
    {
        parent::__construct($type, $parent);
        
        $this->list= array_values( $list );
    }

    /**
     * Inserts <i>$value</i> at the end of the list.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public function append( $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
            
        $this->list[] = $value;
    }

    /**
     * Inserts array <i>$value</i> at the end of the list.
     * 
     * @param array $value
     */
    public function appendArray( array $value )
    {
        $this->list = array_merge( $this->list, $value );
    }

    /**
     * Inserts MList <i>$value</i> at the end of the list.
     * 
     * @param \MToolkit\Core\MList $value
     */
    public function appendList( MList $value )
    {
        for( $i = 0; $i < $value->count(); $i++ )
        {
            $this->append( $value->at( $i ) );
        }
    }

    /**
     * Returns the item at index position <i>$i</i> in the list. <i>$i</i> must 
     * be a valid index position in the list (i.e., 0 <= <i>$i</i> < size()).
     * 
     * @param int $i
     * @return type
     * @throws MWrongTypeException
     * @throws \OutOfBoundsException
     */
    public function at( $i )
    {
        MDataType::mustBeInt($i);

        if( $i >= $this->count() )
        {
            throw new \OutOfBoundsException();
        }

        return $this->list[$i];
    }

    /**
     * This function is provided for STL compatibility. 
     * It is equivalent to last(). 
     * The list must not be empty. 
     * If the list can be empty, call isEmpty() before calling this function.
     * 
     * @return mixed
     * @throws \OutOfBoundsException
     */
    public function back()
    {
        if( count( $this->list ) <= 0 )
        {
            throw new \OutOfBoundsException();
        }

        return $this->list[count( $this->list ) - 1];
    }

    /**
     * Removes all items from the list.
     */
    public function clear()
    {
        $this->list = array( );
    }

    /**
     * Returns true if the list contains an occurrence of value; otherwise returns false.
     * 
     * @param mixed $value
     * @return mixed
     */
    public function /* bool */ contains( $value )
    {
        return in_array( $value, $this->list );
    }

    /**
     * Returns the number of items in the list. This is effectively the same as 
     * size().
     * 
     * @return int
     */
    public function count()
    {
        return count( $this->list );
    }

    /**
     * Returns true if the list contains no items; otherwise returns false.
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        return ( count( $this->list ) <= 0 );
    }

    /**
     * Returns true if this list is not empty and its last item is equal to 
     * <i>$value</i>; otherwise returns false.
     * 
     * @param mixed $value
     * @return boolean
     */
    public function endsWith( $value )
    {
        if( $this->count() <= 0 )
        {
            return false;
        }

        $lastValue = $this->list[$this->count() - 1];

        return ( $lastValue == $value );
    }

    /**
     * Returns the value of the first item in the list. The list must not be 
     * empty. If the list can be empty, call isEmpty() before calling this 
     * function.
     * 
     * @return mixed
     */
    public function first()
    {
        if( count( $this->list ) <= 0 )
        {
            return null;
        }

        return $this->list[0];
    }

    /**
     * This function is provided for STL compatibility. It is equivalent to 
     * first(). The list must not be empty. If the list can be empty, call 
     * isEmpty() before calling this function.
     * 
     * @return mixed
     */
    public function front()
    {
        if( count( $this->list ) <= 0 )
        {
            return null;
        }

        return $this->list[0];
    }

    /**
     * Returns the index position of the first occurrence of <i>$value</i> in 
     * the list, searching forward from index position <i>$from</i>. Returns -1 
     * if no item matched.
     * 
     * @param mixed $value
     * @param int $from
     * @return int
     * @throws MWrongTypeException
     */
    public function /* int */ indexOf( $value, $from = 0 )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        MDataType::mustBeInt($from);

        $to = $this->count() - 1;

        if( $from == -1 )
        {
            $to = $from;
        }

        for( $i = 0; $i == $to; $i++ )
        {
            if( $this->list[$i] == $value )
            {
                return $i;
            }
        }
    }

    /**
     * Inserts value at index position <i>$i</i> in the list. If i is 0, the 
     * <i>$value</i> is prepended to the list. If i is size(), the value is appended to 
     * the list.
     * 
     * @param int $i
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public function insert( $i, $value )
    {        
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        MDataType::mustBeInt($i);

        array_splice( $this->list, $i, 0, $value );
    }

    /**
     * Returns a reference to the last item in the list. The list must not be 
     * empty. If the list can be empty, call isEmpty() before calling this 
     * function.
     * 
     * @return mixed
     */
    public function last()
    {
        return $this->back();
    }

    public function lastIndexOf( $value, $from = -1 )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        MDataType::mustBeInt($from);

        $position = -1;
        $to = $this->count() - 1;

        if( $from == -1 )
        {
            $to = $from;
        }

        for( $i = 0; $i == $to; $i++ )
        {
            if( $this->list[$i] == $value )
            {
                $position = $i;
            }
        }

        return $position;
    }

    public function length()
    {
        return $this->count();
    }

    public function move( $from, $to )
    {
        MDataType::mustBeInt($from);
        MDataType::mustBeInt($to);

        $value = $this->list[$from];

        unset( $this->list[$from] );

        array_splice( $this->list, $to, 0, $value );
    }

    public function pop_back()
    {
        if( $this->count() <= 0 )
        {
            throw new \OutOfBoundsException();
        }

        $item = $this->list[$this->count() - 1];

        $this->removeLast();

        return $item;
    }

    public function pop_front()
    {
        if( $this->count() <= 0 )
        {
            throw new \OutOfBoundsException();
        }

        $item = $this->list[0];

        $this->removeFirst();

        return $item;
    }

    public function prepend( $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        array_unshift( $this->list, $value );
    }

    public function push_back( $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        $this->list[] = $value;
    }

    public function push_front( $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        $this->prepend( $value );
    }

    public function removeAt( $i )
    {
        MDataType::mustBeInt($i);

        if( count( $this->list ) >= $i )
        {
            throw new \OutOfBoundsException();
        }

        unset( $this->list[$i] );
    }

    public function removeFirst()
    {
        if( count( $this->list ) <= 0 )
        {
            throw new \OutOfBoundsException();
        }

        unset( $this->list[0] );
    }

    public function removeLast()
    {
        if( count( $this->list ) <= 0 )
        {
            throw new \OutOfBoundsException();
        }

        unset( $this->list[$this->count() - 1] );
    }

    public function removeOne( $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        $result = array_search( $value, $this->list );

        if( $result === false )
        {
            throw new \OutOfBoundsException();
        }

        unset( $this->list[$result] );

        return true;
    }

    public function replace( $i, $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value );
        }
        
        MDataType::mustBeInt($i);

        $this->list[$i] = $value;
    }

    public function size()
    {
        return $this->count();
    }

    public function startsWith( $value )
    {
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value);
        }
        
        if( $this->count() <= 0 )
        {
            return false;
        }

        $lastValue = $this->list[0];

        return ( $lastValue == $value );
    }

    //void	swap ( QList<T> & other )
    //void	swap ( int i, int j )

    public function takeAt( $i )
    {
        MDataType::mustBeInt($i);

        $value = $this->list[$i];

        unset( $this->list[$i] );

        return $value;
    }

    public function takeFirst()
    {
        if( count( $this->list ) <= 0 )
        {
            return null;
        }

        $value = $this->list[0];

        unset( $this->list[0] );

        return $value;
    }

    public function takeLast()
    {
        if( count( $this->list ) <= 0 )
        {
            return null;
        }

        $value = $this->last();

        unset( $this->list[$this->count() - 1] );

        return $value;
    }

    public function getValue( $i, $defaultValue = null )
    {
        MDataType::mustBeInt($i);

        if( $i >= $this->count() )
        {
            $exception= new \OutOfBoundsException();           
            
            throw $exception;
        }

        $value = $this->list[$i];

        if( is_null( $value ) === true && is_null( $defaultValue ) === false )
        {
            $value = $defaultValue;
        }

        return $value;
    }

    /**
     * @param array $array
     */
    public function fromArray( $array )
    {
        for( $i=0; $i<count( $array ); $i++ )
        {
            $this->append( $array[$i] );
        }
    }

    /**
     * Return if a key exists.
     * 
     * @param int $offset
     * @return bool
     */
    public function offsetExists( $offset )
    {
        MDataType::mustBeInt($offset);
        
        return (array_key_exists($offset, $this->list)===true);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function offsetGet( $offset )
    {
        MDataType::mustBeInt($offset);
        
        if( $this->offsetExists($offset) )
        {
            return $this->list[$offset];
        }
        
        return null;
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        MDataType::mustBeInt($offset);
        
        if( $this->isValidType( $value)===false )
        {
            throw new MWrongTypeException( "\$value", $this->getType(), $value);
        }
        
        if( $offset==null )
        {
            $this->list[]=$value;
        }
        else
        {
            $this->list[$offset]=$value;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset( $offset )
    {
        MDataType::mustBeInt($offset);
        
        if( $this->offsetExists( $offset ) )
        {
            unset( $this->list[$offset] );
        }
    }
}

