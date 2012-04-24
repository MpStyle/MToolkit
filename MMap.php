<?php

class MMap
{
    private $map=array();
    
    public function __construct( $other )
    {
        if( is_array($other) )
        {
            $this->map=  array_merge($this->map, $other);
        }
    }
    
    //QMap ( const QMap<Key, T> & other )

    public function clear()
    {
        $this->map=array();
    }
    
    public function contains( $key )
    {
        $founded =  array_key_exists($key, $this->map);
        
        return ( $founded!==false );
    }
    
    //int count ( const Key & key ) const
    
    public function count ()
    {
        return count($this->map);
    }
    
    public function isEmpty()
    {
        return ( $this->count()==0 );
    }
    
    public function erase( $pos )
    {
        $keys= array_keys( $this->map );
        
        unset( $this->map[ $keys[$pos] ] );
    }
    
    public function find( $key )
    {
        $founded =  array_key_exists($key, $this->map);
        
        if( $founded===false )
        {
            return null;
        }
        
        return $this->map[ $key ];
    }
    
    public function insert ( $key, $value )
    {
        $this->map[$key]=$value;
    }
    
    //iterator	insertMulti ( const Key & key, const T & value )
    
    public function key( $value, $defaultKey=null )
    {
        $key=  array_search($value, $this->map);
        
        if( $key===false && is_null($defaultKey)===false )
        {
            $key=$defaultKey;
        }
        
        return $key;
    }
    
    public function keys ()
    {
        return array_keys( $this->map );
    }
    
    //QList<Key>	keys ( const T & value ) const
    //iterator	lowerBound ( const Key & key )
    //const_iterator	lowerBound ( const Key & key ) const
    
    public function remove ( $key )
    {
        unset( $this->map[ $key ] );
        return 1;
    }
    
    public function size ()
    {
        return $this->count();
    }
    
    //void	swap ( QMap<Key, T> & other )
    
    public function take ( $key )
    {
        $key=$this->value($key);
        $this->remove($key);
        return $key;
    }
    
    //std::map<Key, T>	toStdMap () const
    
    public function uniqueKeys ()
    {
        return $this->keys();
    }
            
    //QMap<Key, T> &	unite ( const QMap<Key, T> & other )
    //iterator	upperBound ( const Key & key )
    //const_iterator	upperBound ( const Key & key ) const
        
    public function value ( $key, $defaultValue=null )
    {
        $value=$this->map[ $key ];
        
        if( is_null( $value )===true && is_null($defaultValue)===false )
        {
            $value=$defaultValue;
        }
        
        return $value;
    }
    
    public function values ()
    {
        return array_values($this->map);
    }
    
    //public function values ( $key )
    
    //bool	operator!= ( const QMap<Key, T> & other ) const
    //QMap<Key, T> &	operator= ( const QMap<Key, T> & other )
    //bool	operator== ( const QMap<Key, T> & other ) const
    //T &	operator[] ( const Key & key )
    //const T	operator[] ( const Key & key ) const
}

?>
