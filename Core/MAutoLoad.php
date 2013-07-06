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

require_once __DIR__.'/MApplication.php';

/**
 * Autoload re-implementation following PSR-0 Standard.
 * No namespaces are defined here, otherwise this method is not
 * called from PHP engine.
 * 
 * @param string $name The class name, namespace included.
 */
function __autoload($name)
{
    $path= str_replace("_", DIRECTORY_SEPARATOR, $name);
    $path= str_replace("\\", "/", $path);
    $path.=".php";
    $path= MToolkit\Core\MApplication::getApplicationDirPath()."/".$path;
        
    if( file_exists( $path )===true )
    {
        require_once $path;
    }
    else
    {
        trigger_error( "Class not found: " . $name, E_USER_WARNING );
    }
}