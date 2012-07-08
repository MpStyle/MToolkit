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

require_once 'MToolkit/View/MUserControl.php';
require_once 'MToolkit/Core/MLog.php';
require_once 'MToolkit/Core/MMap.php';
require_once 'MToolkit/View/Control/MMasterPage.php';

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

class MPage extends MUserControl
{
    private $indent=true;
    private $masterPageFile=null;
    private $contents=null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->contentList=new MMap();
        $this->contents=new MControlList();
    }
    
    public function /* void */ render( /* string */ &$output )
    {      
        if( is_null($this->masterPageFile) )
        {
            parent::render( $output );
        }
        else
        {
            // Import and load the master page
            $lastBackSlashPos=strrpos($this->masterPageFile, "/")+1;
            if( $lastBackSlashPos === false )
            {
                $lastBackSlashPos=0;
            }

            $className= str_replace( ".php", "", substr( $this->masterPageFile, $lastBackSlashPos ) );
            
            require_once $this->masterPageFile;
            $masterPage=new $className();

            // Replace the placeholders of the master page with the page content
            $contentList=$this->contents->toList();
            for( $i=0; $i<$contentList->count(); $i++ )
            {
                $placeHolderId=$contentList->at( $i )->contentPlaceHolderID();
                $placeHolderControlId=$masterPage->controlById( $placeHolderId )->id();
                
                $masterPage->children()->add( $placeHolderControlId, $contentList->at( $i ) );
            }

            // Render the page
            $masterPage->render( $output );
        }
        
        if( $this->indent )
        {
            $output= $this->indentHtml( $output );
        }
    }
    
    public static function show( MControl $istance )
    {
        // Print logs
        if( IS_DEBUG=="true" )
        {
            echo MLog::toHtml();
        }
        
        // Print html
        $output="";
        $istance->render( $output );
        
        echo $output;
    }
    
    public function /* void */ setMasterPageFile( /* string */ $path )
    {
        if( is_string($path)===false )
        {
            throw new WrongTypeException( "\$path", "string", gettype($path) );
        }
        
        $this->masterPageFile=$path;
    }
    
    public function /* string */ masterPageFile()
    {
        return $this->masterPageFile;
    }
    
    public function /* void */ setIndentation( /* bool */ $value )
    {
        if( is_bool( $value )===false )
        {
            throw new WrongTypeException( "\$value", "bool", gettype($value) );
        }
        
        $this->indent=$value;
    }
    
    public function indentation()
    {
        return $this->indent;
    }
    
    public function addedControl( MControl $control, /* int */ $index )
    {
        parent::addedControl( $control, $index );
        
        if( $control instanceof MContent )
        {
            $this->contents->add( $control->id(), $control );
        }
    }

    private function indentHtml($uncleanhtml)
    {
        //Set wanted indentation
        $indent = "\t";

        //Uses previous function to seperate tags
        $fixedtext_array=array();
        $uncleanhtml_array = explode("\n", $uncleanhtml);
        
        foreach ($uncleanhtml_array as $unfixedtextkey => $unfixedtextvalue)
        {
            //Makes sure empty lines are ignores
            if (!preg_match("/^(\s)*$/", $unfixedtextvalue))
            {
                $fixedtextvalue = preg_replace("/>(\s|\t)*</U", ">\n<", $unfixedtextvalue);
                $fixedtext_array[$unfixedtextkey] = $fixedtextvalue;
            }
        }
        
        $fixed_uncleanhtml= implode("\n", $fixedtext_array);
        
        $uncleanhtml_array = explode("\n", $fixed_uncleanhtml);
        
        //Sets no indentation
        $indentlevel = 0;
        foreach ($uncleanhtml_array as $uncleanhtml_key => $currentuncleanhtml)
        {
            //Removes all indentation
            $currentuncleanhtml = preg_replace("/\t+/", "", $currentuncleanhtml);
            $currentuncleanhtml = preg_replace("/^\s+/", "", $currentuncleanhtml);

            $replaceindent = "";

            //Sets the indentation from current indentlevel
            for ($o = 0; $o < $indentlevel; $o++)
            {
                $replaceindent .= $indent;
            }

            //If self-closing tag, simply apply indent
            if (preg_match("/<(.+)\/>/", $currentuncleanhtml))
            { 
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
            }
            //If doctype declaration, simply apply indent
            else if (preg_match("/<!(.*)>/", $currentuncleanhtml))
            { 
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
            }
            //If opening AND closing tag on same line, simply apply indent
            else if (preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && preg_match("/<\/(.*)>/", $currentuncleanhtml))
            { 
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
            }
            //If closing HTML tag or closing JavaScript clams, decrease indentation and then apply the new level
            else if (preg_match("/<\/(.*)>/", $currentuncleanhtml) || preg_match("/^(\s|\t)*\}{1}(\s|\t)*$/", $currentuncleanhtml))
            {
                $indentlevel--;
                $replaceindent = "";
                for ($o = 0; $o < $indentlevel; $o++)
                {
                    $replaceindent .= $indent;
                }

                $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
            }
            //If opening HTML tag AND not a stand-alone tag, or opening JavaScript clams, increase indentation and then apply new level
            else if ((preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && !preg_match("/<(link|meta|base|br|img|hr)(.*)>/", $currentuncleanhtml)) || preg_match("/^(\s|\t)*\{{1}(\s|\t)*$/", $currentuncleanhtml))
            {
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;

                $indentlevel++;
                $replaceindent = "";
                for ($o = 0; $o < $indentlevel; $o++)
                {
                    $replaceindent .= $indent;
                }
            }
            else
            //Else, only apply indentation
            {
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
            }
        }
        
        //Return single string seperated by newline
        return implode("\n", $cleanhtml_array);	
    }
}

