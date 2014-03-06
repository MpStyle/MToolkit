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

require_once __DIR__ . '/Exception/MWrongTypeException.php';

use MToolkit\Core\Exception\MWrongTypeException;

/**
 * In the MDataType class there is a collection of static method to check the
 * type of the data.<br />
 * The data type supported are:
 * <ul>
 * <li>int</li>
 * <li>long</li>
 * <li>boolean</li>
 * <li>float</li>
 * <li>double</li>
 * <li>string</li>
 * <li>nullable int</li>
 * <li>nullable long</li>
 * <li>nullable boolean</li>
 * <li>nullable float</li>
 * <li>nullable double</li>
 * <li>nullable string</li>
 * <li>nullable null</li>
 * </ul>
 * <br />
 * If the data type is not corrected a <i>MWrongTypeException</i> will be 
 * throwed.
 */
class MDataType
{
    const INT=1;
    const LONG=2;
    const BOOLEAN=3;
    const FLOAT=4;
    const DOUBLE=5;
    const STRING=6;
    const NULL=7;
    const __ARRAY=8;
    const OBJECT=9;
    const RESOURCE=10;
    const UNKNOWN=99;
    
    /**
     * Returns the type of <i>$value</i>.
     * 
     * @param mixed $value
     * @return int MDataType::INT, MDataType::LONG, MDataType::BOOLEAN, etc
     */
    public static function getType($value)
    {
        if( is_int( $value ) )
        {
            return MDataType::INT;
        }
        
        if( is_long( $value ) )
        {
            return MDataType::LONG;
        }
        
        if( is_bool( $value ) )
        {
            return MDataType::BOOLEAN;
        }
        
        if( is_float( $value ) )
        {
            return MDataType::FLOAT;
        }
        
        if( is_double( $value ) )
        {
            return MDataType::DOUBLE;
        }
        
        if( is_string( $value ) )
        {
            return MDataType::STRING;
        }
        
        if( $value==null )
        {
            return MDataType::NULL;
        }
        
        if( is_array( $value ) )
        {
            return MDataType::__ARRAY;
        }
        
        if( is_object( $value ) )
        {
            return MDataType::OBJECT;
        }
        
        if( is_resource( $value ) )
        {
            return MDataType::RESOURCE;
        }
        
        return MDataType::UNKNOWN;
    }
    
    /**
     * Throw an exception if <i>$value</i> is not an int.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeInt( $value )
    {        
        if( is_int( $value )===false )
        { 
            throw new MWrongTypeException('\$value', 'int', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a long.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeLong( $value )
    {
        if( is_long( $value )===false )
        { 
            throw new MWrongTypeException('\$value', 'long', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a boolean.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeBoolean( $value )
    {
        if( is_bool( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'boolean', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a float.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeFloat( $value )
    {
        if( is_float( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'float', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a double.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeDouble( $value )
    {
        if( is_double( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'double', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a string.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeString( $value )
    {
        if( is_string( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'string', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNull( $value )
    {
        if( $value!=null )
        {
            throw new MWrongTypeException('\$value', 'null', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not an int or null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNullableInt( $value )
    {
        if( is_int( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'int|null', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a long or null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNullableLong( $value )
    {
        if( is_long( $value )===false && $value!=null )
        { 
            throw new MWrongTypeException('\$value', 'long|null', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a boolean or null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNullableBoolean( $value )
    {
        if( is_bool( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'boolean|null', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a float or null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNullableFloat( $value )
    {
        if( is_float( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'float|null', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a double or null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNullableDouble( $value )
    {
        if( is_double( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'double|null', gettype( $value ));
        }
    }
    
    /**
     * Throw an exception if <i>$value</i> is not a string or null.
     * 
     * @param mixed $value
     * @throws MWrongTypeException
     */
    public static function mustBeNullableString( $value )
    {
        if( is_string( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'string|null', gettype( $value ));
        }
    }
}
