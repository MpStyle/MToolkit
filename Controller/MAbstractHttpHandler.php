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

require_once __DIR__.'/MAbstractController.php';
require_once __DIR__.'/../Core/MDataType.php';

use MToolkit\Controller\MAbstractController;
use MToolkit\Core\MDataType;

abstract class MAbstractHttpHandler extends MAbstractController 
{
    /**
     * @var string
     */
    private $output=null;
    
    public function init()
    {}
    
    public abstract function run();
    
    public static function autorun()
    {
        /* @var $classes string[] */ $classes = array_reverse( get_declared_classes() );
        
        foreach( $classes as $class )
        {
            $type = new \ReflectionClass($class);
            $abstract = $type->isAbstract();
            
            if( is_subclass_of($class, '\MToolkit\Controller\MAbstractHttpHandler')===true && $abstract===false )
            {
                /* @var $handler MAbstractHttpHandler */ $handler = new $class();
                $handler->init();
                $handler->run();
                
                MDataType::mustBeNullableString($handler->getOutput());
                
                if( $handler->getOutput()!=null )
                {
                    echo $handler->getOutput();
                }
                
                // Clean the $_SESSION from signals.
                $handler->disconnectSignals();
                
                return;
            }
        }
    }
    
    /**
     * Returns, by reference, the string to print after the execution of the handler.
     * @return string
     */
    public function &getOutput()
    {
        return $this->output;
    }
    
    /**
     * @param string $output
     * @return \MToolkit\Controller\MAbstractHttpHandler
     */
    public function setOutput( $output )
    {
        MDataType::mustBeNullableString($output);
        
        $this->output = $output;
        return $this;
    }
}

register_shutdown_function(array('\MToolkit\Controller\MAbstractHttpHandler','autorun'));