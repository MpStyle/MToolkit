<?php
namespace MToolkit\Core;

require_once dirname(__FILE__).'/MLog.php';

use \MToolkit\Core\MLog;

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

class MObject
{
    /**
     * @var Receiver[]
     */
    private $signals=array();
    
    /**
     * @param string $signal
     * @param object $context
     * @param string $slot
     */
    public function connect($signal, $context, $slot)
    {
        $receiver=new Receiver();
        $receiver->setContext($context)
                ->setSlot($slot);
        
        // If key not exists
        if( array_key_exists($signal, $this->signals)===false )
        {
            $this->signals[$signal]=array();
        }
        
        $this->signals[$signal][]=$receiver;
    }
    
    /**
     * @param string $signal
     * @param object $context
     * @param string $slot
     */
    public function disconnect($signal, $context, $slot)
    {
        for( $i=0; $i<count($this->signals[$signal]); $i++ )
        {
            $receiver=$this->signals[$signal][$i];
            
            if( $receiver->getContext()==$context && $receiver->getSlot()==$slot )
            {
                unset( $this->signals[$signal][$i] );
            }
        }
    }
    
    /**
     * Call every slots connected with the <i>$signal</i>.
     * 
     * @param string $signal
     * @param mixed $args
     */
    public function emit($signal, $args = null)
    {
        foreach( $this->signals[$signal] as $receiver )
        {
            $method=$receiver->getSlot();
            $object=$receiver->getContext();
            
            if( $args==null )
            {
                $object->$method();
            }
            else
            {
                $object->$method( $args );
            }
        }
    }
}

/**
 * @ignore
 */
class Receiver
{
    private $context;
    private $slot;

    public function getContext()
    {
        return $this->context;
    }

    public function setContext( $context )
    {
        $this->context = $context;
        return $this;
    }

    public function getSlot()
    {
        return $this->slot;
    }

    public function setSlot( $slot )
    {
        $this->slot = $slot;
        return $this;
    }
}

