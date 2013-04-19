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
 * No namespaces are defined here, otherwise this method is not
 * called from PHP engine.
 * 
 * @param string $name The class name, namespace included.
 */
function __autoload($name)
{
    $rootPaths=array();
    $rootPaths=array_merge($rootPaths, (array)\MToolkit\Core\MApplication::getApplicationDirPath() );
    
    $classPath=$name;
    $classPath= str_replace("\\", "/", $classPath);
    $classPath.=".php";
    
    foreach($rootPaths as $rootPath)
    {
        $path= $rootPath."/".$classPath;

        if( file_exists( $path )===true )
        {
            require_once $path;
        }
    }
}

/**
 * Prints a warning message containing the source code file name and line number if <i>$test</i> is false.
 * M_ASSERT() is useful for testing pre- and post-conditions during development. 
 * 
 * @param boolean $test
 */
function M_ASSERT($test)
{
    if ($test !== true)
    {
        $trace = debug_backtrace();
        $lastTrace = $trace[0];

        $output = 'ASSERT FAIL: "%b" in file %s, line %s.<br />';
        $output = sprintf($output, $lastTrace['args'][0], $lastTrace['file'], $lastTrace['line']);

        trigger_error($output, E_USER_WARNING);
    }
}