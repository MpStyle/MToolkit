<?php

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
 * along with Nome-Programma.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 * @version 0.01
 */

require_once 'MToolkit/Core/Exception/WrongTypeException.php';
require_once 'MToolkit/Core/Exception/OutOfBoundException.php';

class MList
{
    private $list=array();
    
    public function __construct()
    {}
    
    //QList ( const QList<T> & other )
    //QList ( std::initializer_list<T> args )
    //~QList ()
    
    public function append( $value )
    {
        $this->list[]=$value;
    }
    
    public function appendArray( array $value )
    {
        $this->list=  array_merge( $this->list, $value );
    }
    
    //public function appendList( MList $value )
    //{}
    
    public function at( $i )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        if( $i>=$this->count() )
        {
            throw new OutOfBoundsException();
        }
        
        return $this->list[$i];
    }
    
    public function back ()
    {
        if( count( $this->list )<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        return $this->list[ count( $this->list )-1 ];
    }
    
    //const T &	back () const
    //iterator	begin ()
    //const_iterator	begin () const
    
    public function clear ()
    {
        $this->list=array();
    }
    
    //const_iterator	constBegin () const
    //const_iterator	constEnd () const
    
    public function /* bool */ contains( $value )
    {
        return in_array($value, $this->list);
    }
    
    //int count ( const T & value ) const
    
    public function count ()
    {
        return count( $this->list );
    }
    
    public function isEmpty()
    {
        return ( count($this->list)<=0 );
    }
    
    //iterator	end ()
    //const_iterator	end () const
    
    public function endsWith ( $value )
    {
        if( $this->count()<=0 )
        {
            return false;
        }
        
        $lastValue=$this->list[ $this->count()-1 ];
        
        return ( $lastValue==$value );
    }
    
    //iterator	erase ( iterator pos )
    //iterator	erase ( iterator begin, iterator end )
    
    public function first()
    {
        if( count( $this->list )<=0 )
        {
            return null;
        }
        
        return $this->list[0];
    }
    
    //const T &	first () const
    
    public function front()
    {
        if( count( $this->list )<=0 )
        {
            return null;
        }
        
        return $this->list[0];
    }
    
    //const T &	front () const
    public function /* int */ indexOf ( $value, $from = 0 )
    {
        if( is_int( $from )===false )
        {
            throw new WrongTypeException( "\$from", "int", gettype($from) );
        }
        
        $to=$this->count()-1;
        
        if( $from==-1 )
        {
            $to=$from;
        }
        
        for( $i=0; $i==$to; $i++ )
        {
            if( $this->list[ $i ]==$value )
            {
                return $i;
            }
        }
    }
            
    public function insert ( $i, $value )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        array_splice($this->list, $i, 0, $value);
    }
    
    //iterator	insert ( iterator before, const T & value )
    
    public function last ()
    {
        return $this->back();
    }
            
    //const T &	last () const
    
    public function /* int */ lastIndexOf( $value, $from = -1 )
    {
        if( is_int( $from )===false )
        {
            throw new WrongTypeException( "\$from", "int", gettype($from) );
        }
        
        $position=-1;
        $to=$this->count()-1;
        
        if( $from==-1 )
        {
            $to=$from;
        }
        
        for( $i=0; $i==$to; $i++ )
        {
            if( $this->list[ $i ]==$value )
            {
                $position=$i;
            }
        }
        
        return $position;
    }
    
    public function length ()
    {
        return $this->count();
    }
    
    //QList<T>	mid ( int pos, int length = -1 ) const
    
    public function /* void */ move( $from, $to )
    {
        if( is_int( $from )===false )
        {
            throw new WrongTypeException( "\$from", "int", gettype($from) );
        }
        
        if( is_int( $to )===false )
        {
            throw new WrongTypeException( "\$to", "int", gettype($to) );
        }
        
        $value=$this->list[ $from ];
        
        unset( $this->list[ $from ] );
        
        array_splice($this->list, $to, 0, $value);
    }
    
    public function pop_back ()
    {
        if( $this->count()<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        $item=$this->list[ $this->count()-1 ];
        
        $this->removeLast();
        
        return $item;
    }
    
    public function pop_front()
    {
        if( $this->count()<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        $item=$this->list[ 0 ];
        
        $this->removeFirst();
        
        return $item;
    }
    
    public function /* void */ prepend( $value )
    {
        array_unshift($this->list, $value );
    }
    
    public function /* void */  push_back( $value )
    {
        $this->list[]=$value;
    }
    
    public function /* void */  push_front( $value )
    {
        $this->prepend( $value );
    }
            
    //int	removeAll ( const T & value )
    
    public function removeAt( $i )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        if( count( $this->list )>=$i )
        {
            throw new OutOfBoundsException();
        }
        
        unset( $this->list[ $i ] );
    }
    
    public function removeFirst()
    {
        if( count( $this->list )<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        unset( $this->list[ 0 ] );
    }
    
    public function removeLast ()
    {
        if( count( $this->list )<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        unset( $this->list[ $this->count()-1 ] );
    }
    
    public function /* bool */ removeOne ( $value )
    {
        $result=array_search($value, $this->list );
        
        if( $result===false )
        {
            throw new OutOfBoundsException();
        }
        
        unset( $this->list[ $result ] );
        
        return true;
    }
    
    public function replace( $i, $value )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        $this->list[$i]=$value;
    }
    
    //void	reserve ( int alloc )
            
    public function size()
    {
        return $this->count();
    }
            
    public function startsWith ( $value )
    {
        if( $this->count()<=0 )
        {
            return false;
        }
        
        $lastValue=$this->list[ 0 ];
        
        return ( $lastValue==$value );
    }
            
    //void	swap ( QList<T> & other )
    //void	swap ( int i, int j )
    
    public function takeAt ( $i )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        $value= $this->list[ $i ];
        
        unset( $this->list[ $i ] );
        
        return $value;
    }
    
    public function takeFirst()
    {
        if( count( $this->list )<=0 )
        {
            return null;
        }
        
        $value= $this->list[ 0 ];
        
        unset( $this->list[ 0 ] );
        
        return $value;
    }
    
    public function takeLast()
    {
        if( count( $this->list )<=0 )
        {
            return null;
        }
        
        $value=$this->last();
        
        unset( $this->list[ $this->count()-1 ] );
        
        return $value;
    }
            
    //QSet<T>	toSet () const
    //std::list<T>	toStdList () const
    //QVector<T>	toVector () const
            
    public function value( $i, $defaultValue=null )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        if( $i>=$this->count() )
        {
            throw new OutOfBoundsException();
        }
        
        $value=$this->list[ $i ];
        
        if( is_null( $value )===true && is_null($defaultValue)===false )
        {
            $value=$defaultValue;
        }
        
        return $value;
    }
            
    //bool	operator!= ( const QList<T> & other ) const
    //QList<T>	operator+ ( const QList<T> & other ) const
    //QList<T> &	operator+= ( const QList<T> & other )
    //QList<T> &	operator+= ( const T & value )
    //QList<T> &	operator<< ( const QList<T> & other )
    //QList<T> &	operator<< ( const T & value )
    //QList<T> &	operator= ( const QList<T> & other )
    //bool	operator== ( const QList<T> & other ) const
    //T &	operator[] ( int i )
    //const T &	operator[] ( int i ) const
}
