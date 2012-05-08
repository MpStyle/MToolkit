<?php
require_once 'MToolkit/Core/MObject.php';

abstract class MControl extends MObject
{
    private $controls=array();
    private $id=null;
    
    public function __construct()
    {
        $this->id="obj_".sha1( microtime() );
    }
    
    protected abstract function init();
    
    public function addControl( $id, MControl $control )
    {
        //echo $id . "<br />\n";
        $this->controls[$id]=$control;
    }
    
    public function /* int */ controlCount()
    {
        return count( $this->controls );
    }
    
    public function /* MControl */ controlByPos( $i )
    {
        if( $i>=$this->controlCount() )
        {
            throw new Exception("Out of bound.");
        }
        
        $keys = array_keys($this->controls);
        
        return $this->controls[ $keys[$i] ];
    }
    
    public function /* MControl */ controlById( $id )
    {
        if( array_key_exists ( $id , $this->controls )===true )
        {
            return $this->controls[ $id ];
        }
        
        return null;
    }
    
    public function /* MControl */ findControlById( $id )
    {
        if( $this->id()==$id )
        {
            return $this;
        }
        
        for( $i=0; $i<$this->controlCount(); $i++ )
        {
            $control= $this->controlByPos($i)->findControlById( $id );
            if( is_null($control)===false && $control->id()==$id )
            {
                return $control;
            }
        }
        
        return null;
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function setId( $id )
    {
        $this->id=$id;
    }
    
    public function render( &$output )
    {
        foreach( $this->controls as $control )
        {
            $control->render( $output );
        }
    }
}
