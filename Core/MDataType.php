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

require_once './Exception/MWrongTypeException.php';

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
    public static function mustBeInt( $value )
    {        
        if( is_int( $value )===false )
        { 
            throw new MWrongTypeException('\$value', 'int', gettype( $value ));
        }
    }
    
    public static function mustBeLong( $value )
    {
        if( is_long( $value )===false )
        { 
            throw new MWrongTypeException('\$value', 'long', gettype( $value ));
        }
    }
    
    public static function mustBeBoolean( $value )
    {
        if( is_bool( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'boolean', gettype( $value ));
        }
    }
    
    public static function mustBeFloat( $value )
    {
        if( is_float( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'float', gettype( $value ));
        }
    }
    
    public static function mustBeDouble( $value )
    {
        if( is_double( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'double', gettype( $value ));
        }
    }
    
    public static function mustBeString( $value )
    {
        if( is_string( $value )===false )
        {
            throw new MWrongTypeException('\$value', 'string', gettype( $value ));
        }
    }
    
    public static function mustBeNull( $value )
    {
        if( $value!=null )
        {
            throw new MWrongTypeException('\$value', 'null', gettype( $value ));
        }
    }
    
    public static function mustBeNullableInt( $value )
    {
        if( is_int( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'int|null', gettype( $value ));
        }
    }
    
    public static function mustBeNullableLong( $value )
    {
        if( is_long( $value )===false && $value!=null )
        { 
            throw new MWrongTypeException('\$value', 'long|null', gettype( $value ));
        }
    }
    
    public static function mustBeNullableBoolean( $value )
    {
        if( is_bool( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'boolean|null', gettype( $value ));
        }
    }
    
    public static function mustBeNullableFloat( $value )
    {
        if( is_float( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'float|null', gettype( $value ));
        }
    }
    
    public static function mustBeNullableDouble( $value )
    {
        if( is_double( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'double|null', gettype( $value ));
        }
    }
    
    public static function mustBeNullableString( $value )
    {
        if( is_string( $value )===false && $value!=null )
        {
            throw new MWrongTypeException('\$value', 'string|null', gettype( $value ));
        }
    }
}
