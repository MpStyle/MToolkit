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
 */

require_once 'MToolkit/View/MControl.php';
require_once 'MToolkit/View/MHtmlControl.php';
require_once 'MToolkit/View/MLiteral.php';

abstract class MUserControl extends MControl
{
    private $html=null;
    
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
    
    public function setTemplate( $html )
    {
        $this->html=$html;
        
        $dom=new DomDocument();
        $dom->loadHTMLFile( $this->html );
        $this->parseHtmlControl( $this, $dom );
    }
    
    private function parseHtmlControl( $parent, $node )
    {
        foreach ($node->childNodes as $childNode)
        {
            switch( $childNode->nodeType )
            {
                // Parse document type
                // TODO: to improve
                case XML_DOCUMENT_TYPE_NODE:
                    $doctype="<!DOCTYPE ".$childNode->name.">";
                    
                    $control=new MLiteral( $doctype );
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
                    // If the tag is an user control, in other words
                    // if the tag name is "user_control"
                    if( $childNode->nodeName=="user_control" )
                    {
                        $control=$this->initUserControl( $childNode );
                    }
                    else
                    {
                        $control=$this->initHtmlControl( $childNode );
                    }
                    
                    // Add control to the parent
                    $parent->children->add( $control->id(), $control );

                    // Parse th children
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
        $include= str_replace(" ", "/", $childNode->getAttribute("include") );
        $class=  $childNode->getAttribute("type"); //substr($childNode->nodeName, strpos($childNode->nodeName, ":")+1);
        
        require_once $include;
        $control=new $class();
        
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
}
