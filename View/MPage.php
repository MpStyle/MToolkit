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

require_once 'MToolkit/View/MUserControl.php';
require_once 'MToolkit/Core/MLog.php';

class MPage extends MUserControl
{
    private $indent=true;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function render( &$output )
    {
        parent::render( $output );
        
        if( $this->indent )
        {
            $output= $this->indentHtml( $output );
        }
    }
    
    public function setIndentation( /* bool */ $value )
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

