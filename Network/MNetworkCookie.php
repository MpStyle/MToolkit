<?php

namespace MToolkit\Network;

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

/**
 * The MNetworkCookie class holds one network cookie.<br />
 * Cookies are small bits of information that stateless protocols like HTTP use 
 * to maintain some persistent information across requests.<br />
 * A cookie is set by a remote server when it replies to a request and it 
 * expects the same cookie to be sent back when further requests are sent.<br />
 * MNetworkCookie holds one such cookie as received from the network. A cookie 
 * has a name and a value, but those are opaque to the application (that is, the 
 * information stored in them has no meaning to the application). A cookie has 
 * an associated path name and domain, which indicate when the cookie should be 
 * sent again to the server.<br />
 * A cookie can also have an expiration date, indicating its validity. If the 
 * expiration date is not present, the cookie is considered a "session cookie" 
 * and should be discarded when the application exits (or when its concept of 
 * session is over).<br />
 */
class MNetworkCookie
{
    /**
     * Returns the value saved in <i>$_COOKIE</i> with <i>$key</i>.
     * 
     * @param string $key
     * @return mixed
     */
    public static function get( $key )
    {
        if ( isset( $_COOKIE[ $key ] ) === false )
        {
            return null;
        }

        return unserialize( $_COOKIE[ $key ] );
    }

    /**
     * Saves the <i>$value</i> in <i>$_COOKIE</i> with <i>$key</i>.<br />
     * <i>$value</i> must be of every kind of type, but resources.
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function set( $key, $value, $expire = 0, $path = "/", $domain = null, $secure = false, $httponly = false )
    {
        setcookie( $key, serialize( $value ), $expire, $path, ($domain == null ? $_SERVER[ 'HTTP_HOST' ] : $domain ), $secure, $httponly );
    }

    public static function delete($key)
    {
        unset($_COOKIE[$key]);
    }

}
