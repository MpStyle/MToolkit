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

/**
 * La classe Cache permette di realizzare file di cache, che possono
 * essere utilizzati per accedere ad informazioni in modo veloce e semplice. 
 */
class MCache
{
    private /* string */ $fileName;
    private /* mixed */ $content;
    
    /**
     * Torna la path completa del file di cache.
     * @return type 
     */
    public function /* string */ fullPath()
    {
        return CachePath.$this->fileName;
    }
    
    /**
     * Torna il nome del file di cache.
     * @return type 
     */
    public function /* string */ fileName()
    {
        return $this->fileName;
    }
    
    /**
     * Setta il nome del file di cache.
     * @param type $fileName 
     */
    public function /* void */ setFileName( /* string */ $fileName )
    {
        $this->fileName=$fileName;
    }
    
    /**
     * Returns true if the file specified by fileName() exists; otherwise returns false.
     * @return boolean 
     */
    public function /* bool */ exists()
    {
        if( $this->fileName==null || $this->fileName=="" )
        {
            return false;
        }
        
        return file_exists ( $this->fullPath() );
    }
    
    /**
     * Torna il contenuto del file di cache.
     * @return mixed 
     */
    public function /* mixed */ content()
    {
        return $this->content;
    }
    
    /**
     * Setta il contenuto del file di cache.
     * @param type $content 
     */
    public function setContent( /* mixed */ $content )
    {
        $this->content=$content;
    }
    
    /**
     * Torna l'età del file di cache
     * @param String $format Formato dell'età (@see http://it.php.net/manual/en/function.date.php).
     * @return String 
     */
    public function age( $format="s" )
    {
        clearstatcache();
        
        $now=new DateTime();
        
        $lastModified= new DateTime();
        $lastModified->setTimestamp( filemtime( $this->fullPath() ) );
        
        $diff=$now->diff( $lastModified );
        
        return $diff->format( $format );
    }
    
    /**
     * Carica il contenuto del file.
     * @throws Exception 
     */
    public function load()
    {
        if( $this->exists()===false )
        {
            throw new Exception("Cache::load() - Cache file not found.");
        }
        
        $content=file_get_contents($this->fullPath(), false);
        
        if( $content === false )
        {
            throw new Exception("Cache::load() - Error read file ".$this->fullPath().".");
        }
        
        $this->content=$content;
    }
    
    /**
     * Crea il file di cache e salva il contenuto del file.
     * @throws Exception 
     */
    public function save()
    {
        $handle = fopen( $this->fullPath(), 'w' );
        
        if( fwrite($handle, $this->content)===false )
        {
            throw new Exception("Cache::save() - Impossible to save cache file (".$this->fullPath().").");
        }
        
        fclose($handle);
    }
    
    public /* bool */ function clear()
    {
        return unlink( $this->fullPath() );
    }
}
