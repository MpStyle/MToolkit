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

class MCookie
{

    /**
     * Return the value saved in <i>$_COOKIE</i> with <i>$key</i>.
     * 
     * @param string $key
     * @return mixed
     */
    public static function get( $key )
    {
        if( isset( $_COOKIE[$key] )===false )
        {
            return null;
        }

        return unserialize( $_COOKIE[$key] );
    }

    /**
     * Save the <i>$value</i> in <i>$_COOKIE</i> with <i>$key</i>.
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function set( $key, $value, $expire = 0, $path="/", $domain=null, $secure = false, $httponly = false )
    {
        setcookie( $key, serialize( $value ), $expire, $path, ($domain==null?$_SERVER['HTTP_HOST']:$domain), $secure, $httponly );
    }
}