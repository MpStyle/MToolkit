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

require_once __DIR__ . '/MObject.php';
require_once __DIR__ . '/../Model/Sql/MDbConnection.php';

use MToolkit\Core\MObject;
use MToolkit\Model\Sql\MDbConnection;

/**
 * The MSettings class provides persistent platform-independent application 
 * settings.
 */
abstract class MSettings extends MObject
{
    /**
     * Returns the database connection by name.
     * 
     * @param string $name
     * @return null
     */
    public static function getDbConnection( $name="DefaultConnection" )
    {
        return MDbConnection::getDbConnection($name);
    }
    
    /**
     * Add a database connection by name.
     * 
     * @param \PDO $connection
     * @param string $name
     */
    public static function addDbConnection( $connection, $name="DefaultConnection" )
    {
        MDbConnection::addDbConnection($connection, $name);
    }

    public abstract function run();

    public static function autorun()
    {
        /* @var $classes string[] */ $classes = array_reverse( get_declared_classes() );
        
        foreach( $classes as $class )
        {
            $type = new \ReflectionClass($class);
            $abstract = $type->isAbstract();
            
            if( is_subclass_of($class, '\MToolkit\Core\MSettings')===true && $abstract===false )
            {
                /* @var $settings \MToolkit\Core\MSettings */ $settings = new $class();
                
                $settings->run();
                
                return;
            }
        }
    }

}

register_shutdown_function( array( '\MToolkit\Core\MSettings', 'autorun' ) );
