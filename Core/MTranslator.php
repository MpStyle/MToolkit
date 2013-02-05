<?php

namespace MToolkit\Core;

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

class MTranslator
{
    private $locales=array();
    private $translations=array();
    
    /**
     * Add a static file containing a PHP array.
     * This file contains the translation for the web site.
     * <i>$locale</i> is a string containing a key for the language.
     * You can use <i>$locate</i> with the standard ('en-UK') or
     * you can use your standard ('foo').
     * 
     * Static file example:
     * <code>
     * return array(
     *      'key_01' => 'value_01'
     *      , 'key_02' => 'value_02'
     *      , ...
     * );
     * </code>
     * 
     * @param string $filePath The path of the file.
     * @param string $locale 
     */
    public function addTranslationFile($filePath, $locale)
    {   
        $this->locales[$locale]=$filePath;
        $this->translations[$locale]=include $filePath;
    }
    
    /**
     * Remove the file of translations associated with <i>$locale</i>.
     * 
     * @param string $locale
     */
    public function removeTranslationFile( $locale )
    {
        unset( $this->locales[$locale] );
        unset( $this->translations[$locale] );
    }

    /**
     * Return the path of the file of the translations associated with <i>$locale</i>.
     * 
     * @param string $locale
     * @return string|null
     */
    public function getTranslationFile( $locale )
    {
        if( isset( $this->locales[$locale] )===false )
        {
            return null;
        }
        
        return $this->locales[$locale];
    }
    
    /**
     * Return the translation for the <i>$message</i> and the <i>$locate</i>.
     * 
     * @param string $message
     * @param string $locale
     * @return null|string
     */
    public function translate($message, $locale)
    {
        if( isset( $this->translations[$locale][$message] ) )
        {
            return null;
        }
        
        return $this->translations[$locale][$message];
    }
    
    /**
     * Return all locales added.
     * 
     * @return string[]
     */
    public function getLocales()
    {
        return array_keys($this->locales);
    }
}
