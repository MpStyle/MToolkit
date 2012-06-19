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
 * along with MToolkit.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

require_once 'MToolkit/View/MControl.php';
require_once 'MToolkit/View/MHtmlControl.php';
require_once 'MToolkit/View/Control/MLiteral.php';

abstract class MUserControl extends MControl
{
    private $html=null;
    private static $controlsRegistered=array(
        "php:mliteral" => "MToolkit/View/Control/MLiteral.php"
        , "php:mpage" => "MToolkit/View/Control/MPage.php"
    );
    
    /**
     * 
     * @param type $html Path all'html del controllo.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    protected function init()
    {
        
    }
    
    public function /* void */ setTemplate( /* string */ $html )
    {
        if( file_exists($html)===false )
        {
            throw new Exception("Template file not found!");
        }
        
        $this->html=$html;
        
        $dom=new DomDocument();
        $dom->load( $this->html );
        $this->parseHtmlControl( $this, $dom );
    }
    
    private function parseHtmlControl( $parent, $node )
    {
        //echo "a";
        foreach ($node->childNodes as $childNode)
        {
            //echo "s";
            switch( $childNode->nodeType )
            {
                // Parse document type
                // TODO: to improve
                case XML_DOCUMENT_TYPE_NODE:
                    $doctype="<!DOCTYPE ".$childNode->name.">";
                    
                    $control=new MLiteral( $doctype );
                    $parent->children->add( $control->id(), $control );
                    break;
                
                // Comments (or Javascript)
                case XML_COMMENT_NODE:
                    $control=new MLiteral( "<!--".$childNode->nodeValue."-->" );
                    $parent->children->add( $control->id(), $control );
                    
                    break;
                
                // Parse text node
                case XML_TEXT_NODE:
                    $resultCount=preg_match('/^[\s]*$/', $childNode->nodeValue, $matches, PREG_OFFSET_CAPTURE);
                    
                    if( $resultCount!==false && $resultCount==0 )
                    {
                        $control=new MLiteral( $childNode->nodeValue );
                        $parent->children->add( $control->id(), $control );
                    }
                    break;
                
                // Parse a tag
                case XML_ELEMENT_NODE:
                    //var_dump( $childNode );
                    //echo $childNode->nodeName . " " . $childNode->prefix . "<br />";
                    
                    if( $childNode->nodeName=="php:register" && $childNode->prefix=="php" )
                    {
                        $this->registerNewControl( $childNode );
                    }
                    else
                    {
                        // If the tag is an user control, in other words
                        // if the tag name is "user_control"
                        if( array_key_exists( $childNode->nodeName, MUserControl::$controlsRegistered) )
                        {
                            $control=$this->initUserControl( $childNode );
                        }
                        else
                        {
                            $control=$this->initHtmlControl( $childNode );
                        }
                    }
                    
                    // Add control to the parent
                    $parent->children->add( $control->id(), $control );

                    // Parse the children
                    if ($childNode->hasChildNodes())
                    {
                        $this->parseHtmlControl($control, $childNode);
                    }
                    
                    break;
            }
        }
        
        //var_dump($parent);
        //echo "<br /><br />\n\n";
    }
    
    private function /* MUserControl */ initUserControl( $childNode )
    {
//        $include= str_replace(" ", "/", $childNode->getAttribute("include") );
//        $class=  $childNode->getAttribute("type"); //substr($childNode->nodeName, strpos($childNode->nodeName, ":")+1);
//        
//        require_once $include;
//        $control=new $class();
        
        $src=MUserControl::$controlsRegistered[ $childNode->nodeName ];
        if( is_null( $src ) )
        {
            throw new Exception( 'No user control "'.$childNode->nodeName.' defined.' );
        }
        
        $lastBackSlashPos=strrpos($src, "/")+1;
        if( $lastBackSlashPos === false )
        {
            $lastBackSlashPos=0;
        }
        
        $className= str_replace( ".php", "", substr( $src, $lastBackSlashPos ) );
        
        require_once $src;
        $control=new $className();
        
        // Parse the properties
        if ($childNode->hasAttributes())
        {
            foreach ($childNode->attributes as $attr)
            {
                if( $attr->nodeName=="id" )
                {
                    $control->setId( $attr->nodeValue );
                }

                $control->properties->insert( $attr->nodeName, $attr->nodeValue );
            }
        }
        
        return $control;
    }
    
    private function /* MHtmlControl */ initHtmlControl( $childNode )
    {
        //echo $childNode->nodeName."<br /><br />\n\n";
        
        $control=new MHtmlControl( $childNode->nodeName );
        
        // Parse the attributes
        if ($childNode->hasAttributes())
        {
            foreach ($childNode->attributes as $attr)
            {
                if( $attr->nodeName=="id" )
                {
                    $control->setId( $attr->nodeValue );
                }

                $control->attributes->add( $attr->nodeName, $attr->nodeValue );
            }
        }
        
        return $control;
    }
    
    private function /* void */ registerNewControl()
    {
        $src= $childNode->getAttribute("src");
        //$className= str_replace( ".php", "", substr( $childNode->getAttribute("src"), strrpos("/", $childNode->getAttribute("src"))) );
        $prefix= $childNode->getAttribute("prefix");
        $tag= $childNode->getAttribute("tag");
        
        if( $prefix=="php" )
        {
            throw new Exception( 'The "php" prefix for user control is not permitted' );
        }
        
        MUserControl::$controlsRegistered[$prefix.":".$tag] = $src;
    }
}
