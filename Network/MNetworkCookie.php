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

require_once __DIR__ . '/../Core/MDataType.php';
require_once __DIR__ . '/../Core/MString.php';

use MToolkit\Core\MDataType;
use MToolkit\Core\MString;

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
     * @var string|null
     */
    private $domain = null;

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var string|null
     */
    private $path = null;

    /**
     * @var string|null
     */
    private $value = null;

    /**
     * @var boolean
     */
    private $secure = false;

    /**
     * @var \DateTime
     */
    private $expirationDate = null;

    /**
     * @var boolean
     */
    private $httpOnly = false;

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

    /**
     * Returns the domain this cookie is associated with. This corresponds to 
     * the "domain" field of the cookie string.<br />
     * Note that the domain here may start with a dot, which is not a valid 
     * hostname. However, it means this cookie matches all hostnames ending with 
     * that domain name.
     * 
     * @return string|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Returns the name of this cookie. The only mandatory field of a cookie is 
     * its name, without which it is not considered valid.
     * 
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the path associated with this cookie. This corresponds to the 
     * "path" field of the cookie string.
     * 
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns this cookies value, as specified in the cookie string. Note that 
     * a cookie is still valid if its value is empty.<br />
     * Cookie name-value pairs are considered opaque to the application: that 
     * is, their values don't mean anything.
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns true if the "secure" option was specified in the cookie string, 
     * false otherwise.<br />
     * Secure cookies may contain private information and should not be resent 
     * over unencrypted connections.
     * 
     * @return boolean
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * Sets the domain associated with this cookie to be <i>$domain</i>.
     * 
     * @param string $domain
     * @return \MToolkit\Network\MCookie
     */
    public function setDomain( $domain )
    {
        MDataType::mustBeNullableString( $domain );

        $this->domain = $domain;
        return $this;
    }

    /**
     * Sets the name of this cookie to be <i>$name</i>. Note that setting a cookie 
     * name to an empty QByteArray will make this cookie invalid.
     * 
     * @param string $name
     * @return \MToolkit\Network\MCookie
     */
    public function setName( $name )
    {
        MDataType::mustBeNullableString( $name );

        $this->name = $name;
        return $this;
    }

    /**
     * Sets the path associated with this cookie to be <i>$path</i>.
     * 
     * @param string $path
     * @return \MToolkit\Network\MNetworkCookie
     */
    public function setPath( $path )
    {
        MDataType::mustBeNullableString( $path );

        $this->path = $path;
        return $this;
    }

    /**
     * Sets the value of this cookie to be <i>$value</i>.
     * 
     * @param string $value
     * @return \MToolkit\Network\MNetworkCookie
     */
    public function setValue( $value )
    {
        MDataType::mustBeNullableString( $value );

        $this->value = $value;
        return $this;
    }

    /**
     * Sets the secure flag of this cookie to <i>$secure</i>.<br />
     * Secure cookies may contain private information and should not be resent 
     * over unencrypted connections.
     * 
     * @param boolean $secure
     * @return \MToolkit\Network\MNetworkCookie
     */
    public function setSecure( $secure )
    {
        MDataType::mustBelBoolean( $secure );

        $this->secure = $secure;
        return $this;
    }

    /**
     * Returns the expiration date for this cookie. If this cookie is a session 
     * cookie, the QDateTime returned will not be valid. If the date is in the 
     * past, this cookie has already expired and should not be sent again back 
     * to a remote server.<br />
     * The expiration date corresponds to the parameters of the "expires" entry 
     * in the cookie string.
     * 
     * @return \DateTime|null
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Sets the expiration date of this cookie to <i>$expirationDate</i>. 
     * Setting an invalid expiration date to this cookie will mean it's a 
     * session cookie.
     * 
     * @param \DateTime $expirationDate
     * @return \MToolkit\Network\MNetworkCookie
     */
    public function setExpirationDate( \DateTime $expirationDate )
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * Returns true if the "HttpOnly" flag is enabled for this cookie.
     * A cookie that is "HttpOnly" is only set and retrieved by the network 
     * requests and replies; i.e., the HTTP protocol. It is not accessible from 
     * scripts running on browsers.
     * 
     * @return boolean
     */
    public function getHttpOnly()
    {
        return $this->httpOnly;
    }

    /**
     * Sets this cookie's "HttpOnly" flag to <i>$httpOnly</i>.
     * 
     * @param boolean $httpOnly
     * @return \MToolkit\Network\MNetworkCookie
     */
    public function setHttpOnly( $httpOnly )
    {
        MDataType::mustBeBoolean( $httpOnly );

        $this->httpOnly = $httpOnly;
        return $this;
    }

    /**
     * Swaps this cookie with <i>$other</i>. This function is very fast and 
     * never fails.
     * 
     * @param \MToolkit\Network\MNetworkCookie $other
     */
    public function swap( MNetworkCookie $other )
    {
        $this->domain = $other->getDomain();
        $this->expirationDate = $other->expirationDate;
        $this->name = $other->getName();
        $this->path = $other->getPath();
        $this->secure = $other->getSecure();
        $this->value = $other->getValue();
        $this->httpOnly = $other->getHttpOnly();
    }

    public function hasSameIdentifier( MNetworkCookie $other )
    {
        return ( $this->name == $other->getName() && $this->domain == $other->getDomain() && $this->path == $other->getPath() );
    }

    /**
     * Returns true if this cookie has the same identifier tuple as other. The 
     * identifier tuple is composed of the name, domain and path.<br />
     * <br />
     * Here an example: <br />
     * <code>
     * &lt;name&gt;=&lt;value&gt;[; &lt;name&gt;=&lt;value&gt;]...<br />
     * [; expires=&lt;date&gt;][; domain=&lt;domain_name&gt;]<br />
     * [; path=&lt;some_path&gt;][; secure][; httponly]<br />
     * </code>
     * <br />
     * The date must use the following format: DAY, DD-MMM-YYYY HH:MM:SS GMT<br />
     * <ul>
     * <li>DAY: The day of the week (Sun, Mon, Tue, Wed, Thu, Fri, Sat).</li>
     * <li>DD: The day in the month (such as 01 for the first day of the month).</li>
     * <li>MMM: The three-letter abbreviation for the month (Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec).</li>
     * <li>YYYY: The year.</li>
     * <li>HH: The hour value in military time (22 would be 10:00 P.M., for example).</li>
     * <li>MM: The minute value.</li>
     * <li>SS: The second value.</li>
     * </ul>
     * 
     * @param int|RawForm $form
     * @return string
     */
    public function toRawForm( $form = RawForm::Full )
    {
        $name=( MString::isNullOrEmpty( $this->getName() ) ? MString::EMPTY_STRING : $this->getName() );
        $value=( MString::isNullOrEmpty( $this->getValue() ) ? MString::EMPTY_STRING : $this->getValue() );
        $toReturn = $name . '=' . $value;

        switch ( $form )
        {
            case RawForm::Full:
                
                if( $this->getExpirationDate()!=null )
                {
                    $toReturn .= '; expires=' . $this->getExpirationDate()->format('D, d-M-Y H:i:s') . ' GMT';
                }
                
                if( $this->getDomain()!=null )
                {
                    $toReturn .= '; domain='.$this->getDomain();
                }
                
                if( $this->getPath()!=null )
                {
                    $toReturn .= '; path='.$this->getPath();
                }
                
                if( $this->getSecure()===true )
                {
                    $toReturn .= '; secure';
                }
                
                if( $this->getHttpOnly()===true )
                {
                    $toReturn .= '; httponly';
                }
                
                break;
            case RawForm::NameAndValueOnly:
                break;
        }

        return $toReturn;
    }

}

final class RawForm
{
    /**
     * makes toRawForm() return only the "NAME=VALUE" part of the cookie, as 
     * suitable for sending back to a server in a client request's "Cookie:" 
     * header. Multiple cookies are separated by a semi-colon in the "Cookie:" 
     * header field.
     */
    const NameAndValueOnly = 0;

    /**
     * makes toRawForm() return the full cookie contents, as suitable for 
     * sending to a client in a server's "Set-Cookie:" header.
     */
    const Full = 1;
}
