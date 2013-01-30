<?php
namespace MToolkit\Core;

session_start();

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
    const ROOT_PATH = "MToolkit_Core_MObject_RootPath";
    const SIGNALS = "MToolkit_Core_MObject_Signals";

    /**
     * @var MObject 
     */
    private $parent=null;
    
    public function __construct( MObject $parent=null )
    {
        $this->parent=$parent;
    }


    /**
     * Set the root path of the project.
     * 
     * @param string $path
     */
    public static function setRootPath( $path )
    {
        $_SESSION[MObject::ROOT_PATH] = $path;
    }

    /**
     * Return the root path of the project.
     * 
     * @return string|null
     */
    public static function getRootPath()
    {
        if ( isset( $_SESSION[MObject::ROOT_PATH] ) === false )
        {
            return null;
        }

        return $_SESSION[MObject::ROOT_PATH];
    }

    /**
     * @param string $signal
     * @param object $context
     * @param string $slot
     */
    public function connect( $signal, $object, $method )
    {
        // Create a slot object
        $slot = new MSlot();
        $slot->setObject( $object )
                ->setMethod( $method );

        // Retrieve the signals
        $signals = $this->getSignals();

        // Create a new signal if not exists
        if ( array_key_exists( $signal, $signals ) === false )
        {
            $signals[$signal] = array( );
        }

        // Add new slot to signal
        $signals[$signal][] = $slot;

        // Store signals
        $this->storeSignals( $signals );
    }

    /**
     * @param string $signal
     * @param object $context
     * @param string $slot
     */
    public function disconnect( $signal, $object, $method )
    {
        // Retrieve the signals
        $signals = $this->getSignals();

        // Remove signal
        for ( $i = 0; $i < count( $signals[$signal] ); $i++ )
        {
            /* @var $slot MSlot */ $slot = $signals[$signal][$i];

            if ( $slot->getObject() == $object && $slot->getMethod() == $method )
            {
                unset( $signals[$signal][$i] );
            }
        }

        // Store signals
        $this->storeSignals( $signals );
    }

    /**
     * Call every slots connected with the <i>$signal</i>.
     * 
     * @param string $signal
     * @param mixed $args
     */
    public function emit( $signal, $args = null )
    {
        // Retrieve the signals
        $signals = $this->getSignals();
        
        $slots=$signals[$signal];
        
        if( $slots==null )
        {
            return;
        }

        foreach ( $slots as /* @var $slot MSlot */ $slot )
        {
            $method = $slot->getMethod();
            $object = $slot->getObject();

            if ( $args == null )
            {
                $object->$method();
            }
            else
            {
                $object->$method( $args );
            }
        }
    }

    /**
     * Return the signals stored in the session.
     * 
     * @return array
     */
    private function getSignals()
    {
        $signals = array( );
        if ( isset( $_SESSION[MObject::SIGNALS] ) )
        {
            $signals = unserialize( $_SESSION[MObject::SIGNALS] );
        }

        return $signals;
    }

    /**
     * Store the <i>$signals</i> in the session.
     * 
     * @param array $signals
     */
    private function storeSignals( $signals )
    {
        $_SESSION[MObject::SIGNALS] = serialize( $signals );
    }

    public function disconnectSignals()
    {
        unset($_SESSION[MObject::SIGNALS]);
    }
    
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(MObject $parent)
    {
        $this->parent = $parent;
        return $this;
    }


}

/**
 * @ignore
 */
class MSlot
{

    private $object;
    private $method;

    public function getObject()
    {
        return $this->object;
    }

    public function setObject( $object )
    {
        $this->object = $object;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod( $method )
    {
        $this->method = $method;
        return $this;
    }

}

