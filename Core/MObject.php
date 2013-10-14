<?php
namespace MToolkit\Core;

require_once __DIR__ . '/MSession.php';
require_once __DIR__ . '/MGet.php';
require_once __DIR__ . '/MPost.php';

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

use MToolkit\Core\MGet;
use MToolkit\Core\MPost;

class MObject
{
    const SIGNALS = "MToolkit\Core\MObject\Signals";

    /**
     * @var MSlot[]
     */
    private $signals = array( );

    /**
     * @var array
     */
    private $properties = array( );

    /**
     * @var bool
     */
    private $signalsBlocked = false;

    /**
     * @var MPost
     */
    private $post;

    /**
     * @var MGet
     */
    private $get;

    /**
     * @var MObject 
     */
    private $parent = null;

    public function __construct( MObject $parent = null )
    {
        $this->parent = $parent;

        $this->post = new MPost();
        $this->get = new MGet();
    }

    /**
     * @return bool
     */
    public function getSignalsBlocked()
    {
        return $this->signalsBlocked;
    }

    /**
     * @param bool $signalsBlocked
     * @return \MToolkit\Core\MObject
     */
    public function setSignalsBlocked( $signalsBlocked )
    {
        $this->signalsBlocked = $signalsBlocked;
        return $this;
    }

    /**
     * @param \MToolkit\Core\MObject $sender
     * @param string $signal
     * @param \MToolkit\Core\MObject $receiver
     * @param string $method
     */
    public function connect( MObject $sender, $signal, MObject $receiver, $method )
    {
        if( $sender!=$this )
        {
            $sender->connect( $sender, $signal, $receiver, $method );
        }

        $slot = new MSlot();
        $slot->setMethod( $method )
                ->setSender( $sender );

        $this->signals[$signal] = $slot;
    }

    /**
     * @param \MToolkit\Core\MObject $sender
     * @param string $signal
     * @param \MToolkit\Core\MObject $receiver
     * @param string $method
     */
    public function disconnect( MObject $sender, $signal, MObject $receiver, $method )
    {
        if( $this!=$sender )
        {
            $sender->disconnect( $sender, $signal, $receiver, $method );
        }

        if( !isset( $this->signals[$signal] ) )
        {
            return;
        }

        unset( $this->signals[$signal] );
    }

    /**
     * Call every slots connected with the <i>$signal</i>.
     * 
     * @param string $signal
     * @param mixed $args
     */
    public function emit( $signal, $args = null )
    {
        if( $this->signalsBlocked )
        {
            return;
        }

        if( isset( $this->signals[$signal] )===false )
        {
            return;
        }

        $slots = $this->signals[$signal];

        foreach( $slots as /* @var $slot MSlot */ $slot )
        {
            $method = $slot->getMethod();
            $object = $slot->getObject();

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

    /**
     * Remove all signals
     */
    public function disconnectSignals()
    {
        $this->signals = array( );
    }

    /**
     * @return MObject
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent( MObject $parent )
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @deprecated 
     * @param string $key
     * @return string|null
     */
    public function post( $key )
    {
        if( isset( $_POST[$key] )===false )
        {
            return null;
        }

        return $_POST[$key];
    }

    /**
     * @deprecated 
     * @param string $key
     * @return string|null
     */
    public function get( $key )
    {
        if( isset( $_GET[$key] )===false )
        {
            return null;
        }

        return $_GET[$key];
    }

    /**
     * Return a MMap with the data in <i>$_POST</i>
     * 
     * @return MPost
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Return a MMap with the data in <i>$_GET</i>
     * 
     * @return MGet
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * Returns the value of the object's <i>$name</i> property.
     * 
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        return $this->getProperty( $name );
    }

    /**
     * Sets the value of the object's <i>$name</i> property to <i>$value</i>.
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set( $name, $value )
    {
        $this->setProperty( $name, $value );
    }

    /**
     * Returns the value of the object's <i>$name</i> property.
     * @param string $name
     * @return mixed
     */
    public function getProperty( $name )
    {
        return $this->properties[$name];
    }

    /**
     * Sets the value of the object's <i>$name</i> property to <i>$value</i>.
     * 
     * @param string $name
     * @param mixed $value
     */
    public function setProperty( $name, $value )
    {
        $this->properties[$name] = $value;
    }

    /**
     * @param bool $obj
     * @return boolean
     */
    public function equals( $obj )
    {
        return MObject::areEquals( $this, $obj );
    }

    /**
     * @param mixed $obj1
     * @param mixed $obj2
     * @return boolean
     * @throws Exception
     */
    public static function areEquals( $obj1, $obj2 )
    {
        if( gettype( $obj1 )!=gettype( $obj2 ) )
        {
            return false;
        }

        switch( gettype( $obj1 ) )
        {
            case "boolean":
                return ($obj1===$obj2);
                break;
            case "integer":
            case "double":
            case "string":
                return ($obj1==$obj2);
                break;
            case "array":
                return (count( array_diff( $obj1, $obj2 ) )==0);
                break;
            case "object":
                // Do nothing
                break;
            case "NULL":
                return true;
                break;
            default:
                throw new Exception( 'Types like "resource" and "unknown type" are incomparable.' );
                break;
        }

        if( get_class( $obj1 )!=get_class( $obj2 ) )
        {
            return false;
        }

        $reflectObj1 = new \ReflectionClass( $obj1 );
        $reflectObj2 = new \ReflectionClass( $obj2 );

        /* @var $propertiesThis \ReflectionProperty[] */ $propertiesObj1 = $reflectObj1->getProperties();
        /* @var $propertiesObj \ReflectionProperty[] */ $propertiesObj2 = $reflectObj2->getProperties();

        if( count( $propertiesObj1 )!=count( $propertiesObj2 ) )
        {
            return false;
        }

        for( $i = 0; $i<count( $obj1 ); $i++ )
        {
            /* @var $propertyObj1 \ReflectionProperty */ $propertyObj1 = $propertiesObj1[$i];
            /* @var $propertyObj2 \ReflectionProperty */ $propertyObj2 = $propertiesObj2[$i];

            $propertyObj1->setAccessible( true );
            $propertyObj2->setAccessible( true );

            $areEquals = MObject::areEquals( $propertyObj1->getValue( $obj1 ), $propertyObj2->getValue( $obj2 ) );
            if( $areEquals===false )
            {
                return false;
            }
        }

        return true;
    }

}

/**
 * @ignore
 */
class MSlot
{
    /**
     *
     * @var MObject
     */
    private $sender;

    /**
     * @var string
     */
    private $method;

    /**
     * @return MObject
     */
    public function getSender()
    {
        return $this->sender;
    }

    public function setSender( MObject $sender )
    {
        $this->sender = $sender;
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

