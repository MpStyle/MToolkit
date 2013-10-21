<?php
namespace MToolkit\Controller;

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

require_once __DIR__.'/../Core/MObject.php';

use MToolkit\Core\MObject;

abstract class MAbstractHttpHandler extends MObject 
{
    public abstract function run();
    
    public static function autorun()
    {
        /* @var $classes string[] */ $classes = get_declared_classes();

        /* @var $entryPoint string */ $entryPoint = $classes[count( $classes ) - 1];

        /* @var $controller \MToolkit\Controller\MAbstractController */ $controller = new $entryPoint();

        if ( ( $controller instanceof \MToolkit\Core\MAutorunClass ) === false )
        {
            $message = sprintf( "Invalid object for entry point in class %s, it must be an instance of MAutorunClass, %s is passed.", get_class( $this ), get_class( $controller ) );

            throw new \Exception( $message );
        }
        
        $controller->run();

        // Clean the $_SESSION from signals.
        $controller->disconnectSignals();
    }
}

register_shutdown_function(array('\MToolkit\Controller\MAbstractHttpHandler','autorun'));