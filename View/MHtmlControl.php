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

require_once 'MToolkit/View/MControl.php';

class MHtmlControl extends MControl
{
    private $isShortTag=false;
    private $name="";
    private $attributes=Array();
    private static $shortTags=array("meta","img","br");
    
    public function __construct( $name )
    {
        parent::__construct();
        
        $this->name=$name;
        
        if( array_search( $this->name, MHtmlControl::$shortTags )!==false )
        {
            $this->isShortTag=true;
        }
    }
    
    public function /* string */ name()
    {
        return $this->name;
    }
    
    public function /* void */ addAttribute( $key, $value )
    {
        $this->attributes[$key]=$value;
    }
    
    public function /* void */ setAttribute( $key, $value )
    {
        if( array_key_exists( $key, $this->attributes )===false )
        {
            throw new Exception("Attribute does not exists.");
        }
        
        $this->attributes[$key]=$value;
    }
    
    public function /* void */ addAttributes( array $attributes )
    {
        $this->attributes=array_merge($this->attributes, $attributes);
    }
    
    public function /* int */ attributeCount()
    {
        return count( $this->attributes );
    }
    
    public function /* void */ attributeByPos( $i )
    {
        $keys = key($this->attributes);
        return $this->attributes[ $keys[$i] ];
    }
    
    public function /* string */ attributeByKey( $key )
    {
        return $this->attributes[ $key ];
    }
    
    public function /* void */ renderAttributes( &$output )
    {
        $preRender=array();
        
        foreach( $this->attributes as $key => $value )
        {
            $preRender[]=$key."=\"".$value."\"";
        }
        
        $output.=join(" ", $preRender);
    }
    
    public function /* void */ render( &$output)
    {   
        $output.="<".$this->name;
        if( count( $this->attributes )>0 )
        {
            $output.=" ";
            $this->renderAttributes($output);
        }
        
        if( $this->isShortTag===true )
        {
            $output.=" />";
            return;
        }
        
        $output.=">";
        
        parent::render( $output );
        
        $output.="</".$this->name.">";
    }
    
    public static /* string */ function __namespace( $tagName )
    {
        $pos=strpos($tagName, ":");
        
        if($pos===false)
        {
            return "";
        }
        
        $namespace=substr($tagName, 0, $pos );
        return $namespace;
    }

    protected function init()
    {
        
    }
}

