<?php
require_once 'MToolkit/View/MControl.php';
require_once 'MToolkit/View/MHtmlControl.php';
require_once 'MToolkit/View/MTextHtmlControl.php';

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
                case XML_DOCUMENT_TYPE_NODE:
                    // TODO: questa è una pagina e setto il document type
                    break;
                
                case XML_TEXT_NODE:
                    $resultCount=preg_match('/^[\s]*$/', $childNode->nodeValue, $matches, PREG_OFFSET_CAPTURE);
                    
                    if( $resultCount!==false && $resultCount==0 )
                    {
                        $control=new MTextHtmlControl( $childNode->nodeValue );
                        $parent->addControl( $control->id(), $control );
                    }
                    break;
                
                case XML_ELEMENT_NODE:
                    $namespace=MHtmlControl::__namespace($childNode->nodeName);
                
                    switch( $namespace )
                    {
                        case "mt":
                            $control=$this->initUserControl( $childNode );
                            break;
                        case "":
                            $control=$this->initHtmlControl( $childNode );
                            break;
                    }

                    $parent->addControl( $control->id(), $control );

                    if ($childNode->hasChildNodes())
                    {
                        $this->parseHtmlControl($control, $childNode);
                    }
                    
                    break;
            }
        }
    }
    
    private function /* MUserControl */ initUserControl( $childNode )
    {
        $include= str_replace(" ", "/", $childNode->getAttribute("include") );
        $class=  substr($childNode->nodeName, strpos($childNode->nodeName, ":")+1);
        
        require $include;
        $control=new $class();
        
        if ($childNode->hasAttributes())
        {
            foreach ($childNode->attributes as $attr)
            {
                if( $attr->nodeName=="id" )
                {
                    $control->setId( $attr->nodeValue );
                }
                
                $control->addProperty( $attr->nodeName, $attr->nodeValue );
            }
        }
        
        return $control;
    }
    
    private function /* MHtmlControl */ initHtmlControl( $childNode )
    {
        $control=new MHtmlControl( $childNode->nodeName );

        if ($childNode->hasAttributes())
        {
            foreach ($childNode->attributes as $attr)
            {
                if( $attr->nodeName=="id" )
                {
                    $control->setId( $attr->nodeValue );
                }
                
                $control->addAttribute( $attr->nodeName, $attr->nodeValue );
            }
        }

        return $control;
    }
}

