<?php
namespace MToolkit\Core\Json;

class MJsonObject
{

    /**
     * Returns a string rappresenting the json of the object.
     * 
     * @return array 
     */
    public function toArray()
    {
        $reflect = new \ReflectionClass( $this );
        $propertyList = $reflect->getProperties();
        $toReturn = array();

        foreach ( $propertyList as &$property )
        {
            $reflectionProperty = $reflect->getProperty( $property->getName() );
            $reflectionProperty->setAccessible( true );
            
            $propertyValue=$reflectionProperty->getValue($this);
            
            if ( is_object( $propertyValue ) )
            {
                if( method_exists( $propertyValue, 'toArray' ) )
                {
                    $toReturn[$property->getName()] = $propertyValue->toArray();
                }
                else
                {
                    $toReturn[$property->getName()] = null;
                }
            }
            else
            {
                $toReturn[$property->getName()] = $propertyValue;
            }
        }
        return $toReturn;
    }

    /**
     * Sets the property of the class, using the <i>$json</i>.
     * The default implementation returns null.
     * 
     * @param array $json
     * @return MJsonObject 
     */
    public static function fromArray( array $json )
    {
        return null;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
    
    /**
     * @param string $json
     * @return MJsonObject
     */
    public static function fromJson( $json )
    {
        return MJsonObject::fromArray( json_decode($json) );
    }
}

