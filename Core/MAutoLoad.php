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

/**
 * Autoload re-implementation following PSR-0 Standard.
 * No namespaces are defined here, because otherwise this method is not
 * called from PHP engine.
 * 
 * @param string $name
 */
function __autoload($name)
{
    $path=$name;
    $path= str_replace("\\", "/", $path);
    $path.=".php";
    $path=  \MToolkit\Core\MObject::getRootPath()."/".$path;
        
    if( file_exists( $path )===true )
    {
        require_once $path;
    }
    else
    {
        throw new \Exception("Class not found: " . $name);
    }
}