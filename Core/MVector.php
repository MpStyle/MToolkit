<?php

class MVector
{
    private $vector=array();
    
    public function __ruct()
    {}
    
    public function append ( $value )
    {
        $this->vector[]=$value;
    }
    
    public function at( $i )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        if( $i>=$this->count() )
        {
            return null;
        }
        
        return $this->vector[ $i ];
    }
    
    //reference back ()
    //_reference back () 
    //iterator begin ()
    //_iterator begin () 
    
    public function capacity ()
    {
        return $this->count();
    }
    
    public function clear ()
    {
        $this->vector=array();
    }
    
    //_iterator Begin () 
    // T * Data () 
    //_iterator End () 
    
    public function contains ( $value )
    {
        return in_array($value, $this->vector);
    }
    
    //int count (  T & value ) 
    
    public function count ()
    {
        return count( $this->vector );
    }
    
    //T * data()
    // T * data () 
    
    public function isEmpty ()
    {
        return ( count( $this->vector )==0 );
    }
    
    //iterator end ()
    //_iterator end () 
    public function /* bool */ endsWith ( $value ) 
    {}
    
    //iterator erase ( iterator pos )
    //iterator erase ( iterator begin, iterator end )
    //QVector<T> & fill (  T & value, int size = -1 )
    public function first() 
    {
        if( 0>=$this->count() )
        {
            throw new OutOfBoundsException();
        }
        
        return $this->vector[0];
    }
    
    public function front () 
    {
        return $this->first();
    }
    
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
            if( $this->vector[ $i ]==$value )
            {
                return $i;
            }
        }
    }
    
    //iterator insert ( iterator before, int count,  T & value )
    public function /* void */ insert ( $i, $value, $count=1 ) 
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        if( is_int( $count )===false )
        {
            throw new WrongTypeException( "\$count", "int", gettype($count) );
        }
        
        for( $j=1; j<=$count; $j++ )
        {
            array_splice($this->vector, $i, 0, $value);
        }
    }
    
    //iterator insert ( iterator before,  T & value ) 
    public function last() 
    {
        if( $this->count()<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        return $this->vector[ $this->count()-1 ];
    }
    
    public function /* int */ lastIndexOf (  $value, $from = -1 )  
    {}
    
    //QVector<T> mid ( int pos, int length = -1 ) 
    public function /* void */ pop_back () 
    {
        if( $this->count()<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        $item=$this->vector[ $this->count()-1 ];
        
        $this->removeLast();
        
        return $item;
    }
    
    public function /* void */ pop_front () 
    {
        if( $this->count()<=0 )
        {
            throw new OutOfBoundsException();
        }
        
        $item=$this->vector[ 0 ];
        
        $this->removeFirst();
        
        return $item;
    }
    
    public function /* void */ prepend (  $value ) 
    {
        array_unshift($this->list, $value );
    }
    
    public function /* void */ push_back (  $value ) 
    {
        $this->list[]=$value;
    }
    
    public function /* void */ push_front (  $value ) 
    {
        $this->prepend( $value );
    }
    
    public function /* void */ remove ( $i ) 
    {}
    
    public function /* void */ remove( $i, $count ) 
    {}
    
    public function /* void */ replace ( $i,  $value ) 
    {}
    
    public function /* void */ reserve ( $size ) 
    {}
    
    public function /* void */ resize ( $size ) 
    {}
    
    public function /* int */ size ()  
    {}
    
    public function /* void */ squeeze () 
    {}
    
    public function /* bool */ startsWith (  $value )  
    {}
    
    //public function /* void */ swap ( QVector<T> & other )            
    //QList<T> toList () 
    //std::vector<T> toStdVector () 
            
    public function value( $i, $defaultValue=null )
    {
        if( is_int( $i )===false )
        {
            throw new WrongTypeException( "\$i", "int", gettype($i) );
        }
        
        $value=$this->list[ $i ];
        
        if( is_null( $value )===true && is_null($defaultValue)===false )
        {
            $value=$defaultValue;
        }
        
        return $value;
    }
            
    //bool operator!= (  QVector<T> & other ) 
    //QVector<T> operator+ (  QVector<T> & other ) 
    //QVector<T> & operator+= (  QVector<T> & other )
    //QVector<T> & operator+= (  T & value )
    //QVector<T> & operator<< (  T & value )
    //QVector<T> & operator<< (  QVector<T> & other )
    //QVector<T> & operator= (  QVector<T> & other )
    //bool operator== (  QVector<T> & other ) 
    //T & operator[] ( int i )
    // T & operator[] ( int i ) 
}

