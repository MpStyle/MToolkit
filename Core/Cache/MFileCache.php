<?php

namespace MToolkit\Core\Cache;

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

require_once __DIR__.'/MAbstractCache.php';

class MFileCache extends MAbstractCache
{
    public function __construct( MObject $parent = null )
    {
        parent::__construct( $parent );
    }

    /**
     * @var string 
     */
    const CACHE_FILE_PREFIX = "cache_";
    const DELIMITER = "$$$$";
    const FILE_EXTENSION = "mcache";

    /**
     * @var string
     */
    private $path = null;

    /**
     * Return the path of the cache.
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path of the cache.
     * 
     * @param string $path
     * @return \MToolkit\Core\MCache
     */
    public function setPath( $path )
    {
        $this->path = $path;
        $len = strlen( $this->path );

        if( $this->path{$len - 1} != DIRECTORY_SEPARATOR )
        {
            $this->path.=DIRECTORY_SEPARATOR;
        }

        return $this;
    }

    /**
     * Remove a single cache file.
     * 
     * @param string $key
     */
    public function delete( $key )
    {
        unlink( $this->generateFileName( $key ) );
    }

    /**
     * Remove all cache files.
     */
    public function flush()
    {
        $files = glob( $this->path . MCache::CACHE_FILE_PREFIX . '*' ); // get all file names
        foreach( $files as $file )
        {
            if( is_file( $file ) )
                unlink( $file );
        }
    }

    /**
     * Return the content of a cache file with <i>$key</i>.
     * 
     * @param string $key
     * @return string|null
     */
    public function get( $key )
    {
        if( file_exists( $this->generateFileName( $key ) ) === false )
        {
            return null;
        }

        $fileContent = file_get_contents( $this->generateFileName( $key ) );

        $separatorPosition = strrpos( $fileContent, MCache::DELIMITER );
        $expired = substr( $fileContent, 0, $separatorPosition );
        $cache = substr( $fileContent, $separatorPosition + strlen( MCache::DELIMITER ) );
        
        if( $expired==-1 || $expired > time() )
        {
            return unserialize($cache);
        }
        
        $this->delete($key);
        return null;
    }

    /**
     * Store a <i>$value</i> in a cache file with <i>$key</i>.
     * It is possible to pass a timestamp (seconds) for the expiration.
     * 
     * @param string $key
     * @param string $value
     * @param float $expired
     * @return bool
     */
    public function set( $key, $value, $expired = -1 )
    {
        if( file_exists( MCache::generateFileName( $key ) ) === true )
        {
            $this->delete( $key );
        }
        
        $success = file_put_contents( $this->generateFileName( $key ), $expired . MCache::DELIMITER . serialize($value) );
        return ($success != false);
    }

    private function generateFileName( $key )
    {
        return $this->path . MCache::CACHE_FILE_PREFIX . $key . '.' . MCache::FILE_EXTENSION;
    }

}