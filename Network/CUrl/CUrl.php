<?php

namespace MToolkit\Network\CUrl;

/* Copyright (c) 2008 James Socol

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
 */

/**
 * CUrl connection object
 *
 * Provides an Object-Oriented interface to the PHP cURL
 * functions and a clean way to replace curl_setopt().
 *
 * Instead of requiring a setopt() function and the CURLOPT_*
 * constants, which are cumbersome and ugly at best, this object
 * implements curl_setopt() through overloaded getter and setter
 * methods.
 *
 * For example, if you wanted to include the headers in the output,
 * the old way would be
 *
 * <code>
 * curl_setopt($ch, CURLOPT_HEADER, true);
 * </code>
 *
 * But with this object, it's simply
 *
 * <code>
 * $ch->header = true;
 * </code>
 *
 * <b>NB:</b> Since, in my experience, the vast majority
 * of cURL scripts set CURLOPT_RETURNTRANSFER to true, the {@link CUrl}
 * class sets it by default. If you do not want CURLOPT_RETURNTRANSFER,
 * you'll need to do this:
 *
 * <code>
 * $c = new CUrl;
 * $c->returntransfer = false;
 * </code>
 */
class CUrl
{

    /**
     * Store the curl_init() resource.
     * @var resource
     */
    protected $ch = NULL;

    /**
     * Store the CURLOPT_* values.
     *
     * Do not access directly. Access is through {@link __get()}
     * and {@link __set()} magic methods.
     *
     * @var array
     */
    protected $curlopt = array();

    /**
     * Flag the CUrl object as linked to a {@link CUrlParallel}
     * object.
     *
     * @var bool
     */
    protected $multi = false;

    /**
     * Store the response. Used with {@link fetch()} and
     * {@link fetch_json()}.
     *
     * @var string
     */
    protected $response;

    /**
     * Create the new {@link CUrl} object, with the
     * optional URL parameter.
     *
     * @param string $url The URL to open (optional)
     * @return CUrl A new CUrl object.
     * @throws ErrorException
     */
    public function __construct($url = NULL)
    {
        // Make sure the cURL extension is loaded
        if (!extension_loaded('curl'))
            throw new \ErrorException("cURL library is not loaded. Please recompile PHP with the cURL library.");

        // Create the cURL resource
        $this->ch = curl_init();

        // Set some default options
        $this->url = $url;
        $this->returntransfer = true;

        // Applications can override this User Agent value
        $this->useragent = 'OOCUrl';

        // Return $this for chaining
        return $this;
    }

    /**
     * When destroying the object, be sure to free resources.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * If the session was closed with {@link CUrl::close()}, it can be reopened.
     *
     * This does not re-execute {@link CUrl::__construct()}, but will reset all
     * the values in {@link $curlopt}.
     *
     * @param string $url The URL to open (optional)
     * @return bool|CUrl
     */
    public function init($url = NULL)
    {
        // If it's still init'ed, return false.
        if ($this->ch)
            return false;

        // init a new cURL session
        $this->ch = curl_init();

        // reset all the values that were already set
        foreach ($this->curlopt as $const => $value)
        {
            curl_setopt($this->ch, constant($const), $value);
        }

        // finally if there's a new URL, set that
        if (!empty($url))
            $this->url = $url;

        // return $this for chaining
        return $this;
    }

    /**
     * Execute the cURL transfer.
     *
     * @return mixed
     */
    public function exec()
    {
        return curl_exec($this->ch);
    }

    /**
     * If the CUrl object was added to a {@link CUrlParallel}
     * object, then you can use this function to get the
     * returned data (whatever that is). Otherwise it's similar
     * to {@link exec()} except it saves the output, instead of
     * running the request repeatedly.
     *
     * @see $multi
     * @return mixed
     */
    public function fetch()
    {
        if ($this->multi)
        {
            return curl_multi_getcontent($this->ch);
        }
        else
        {
            if ($this->response)
            {
                return $this->response;
            }
            else
            {
                $this->response = curl_exec($this->ch);
                return $this->response;
            }
        }
    }

    /**
     * Fetch a JSON encoded value and return a JSON
     * object. Requires the PHP JSON functions. Pass TRUE
     * to return an associative array instead of an object.
     *
     * @param bool array optional. Return an array instead of an object.
     * @return mixed an array or object (possibly null).
     */
    public function fetch_json($array = false)
    {
        return json_decode($this->fetch(), $array);
    }

    /**
     * Close the cURL session and free the resource.
     */
    public function close()
    {
        if (!empty($this->ch) && is_resource($this->ch))
            curl_close($this->ch);
    }

    /**
     * Return an error string from the last execute (if any).
     *
     * @return string
     */
    public function error()
    {
        return curl_error($this->ch);
    }

    /**
     * Return the error number from the last execute (if any).
     *
     * @return integer
     */
    public function errno()
    {
        return curl_errno($this->ch);
    }

    /**
     * Get information about this transfer.
     *
     * Accepts any of the following as a parameter:
     *  - Nothing, and returns an array of all info values
     *  - A CURLINFO_* constant, and returns a string
     *  - A string of the second half of a CURLINFO_* constant,
     *     for example, the string 'effective_url' is equivalent
     *     to the CURLINFO_EFFECTIVE_URL constant. Not case
     *     sensitive.
     *
     * @param mixed $opt A string or constant (optional).
     * @return mixed An array or string.
     */
    public function info($opt = false)
    {
        if (false === $opt)
        {
            return curl_getinfo($this->ch);
        }

        if (is_int($opt) || ctype_digit($opt))
        {
            return curl_getinfo($this->ch, $opt);
        }

        if (constant('CURLINFO_' . strtoupper($opt)))
        {
            return curl_getinfo($this->ch, constant('CURLINFO_' . strtoupper($opt)));
        }
    }

    /**
     * Magic property setter.
     *
     * A sneaky way to access curl_setopt(). If the
     * constant CURLOPT_$opt exists, then we try to set
     * the option using curl_setopt() and return its
     * success. If it doesn't exist, just return false.
     *
     * Also stores the variable in {@link $curlopt} so
     * its value can be retrieved with {@link __get()}.
     *
     * @param string $opt The second half of the CURLOPT_* constant, not case sensitive
     * @param mixed $value
     * @return void
     */
    public function __set($opt, $value)
    {
        $const = 'CURLOPT_' . strtoupper($opt);
        if (defined($const))
        {
            if (curl_setopt($this->ch, constant($const), $value))
            {
                $this->curlopt[$const] = $value;
            }
        }
    }

    /**
     * Magic property getter.
     *
     * When options are set with {@link __set()}, they
     * are also stored in {@link $curlopt} so that we
     * can always find out what the options are now.
     *
     * The default cURL functions lack this ability.
     *
     * @param string $opt The second half of the CURLOPT_* constant, not case sensitive
     * @return mixed The set value of CURLOPT_<var>$opt</var>, or NULL if it hasn't been set (ie: is still default).
     */
    public function __get($opt)
    {
        return $this->curlopt['CURLOPT_' . strtoupper($opt)];
    }

    /**
     * Magic property isset()
     *
     * Can tell if a CURLOPT_* value was set by using
     * <code>
     * isset($curl->*)
     * </code>
     *
     * The default cURL functions lack this ability.
     *
     * @param string $opt The second half of the CURLOPT_* constant, not case sensitive
     * @return bool
     */
    public function __isset($opt)
    {
        return isset($this->curlopt['CURLOPT_' . strtoupper($opt)]);
    }

    /**
     * Magic property unset()
     *
     * Unfortunately, there is no way, short of writing an
     * extremely long, but mostly NULL-filled array, to
     * implement a decent version of
     * <code>
     * unset($curl->option);
     * </code>
     *
     * @todo Consider implementing an array of all the CURLOPT_*
     *       constants and their default values.
     * @param string $opt The second half of the CURLOPT_* constant, not case sensitive
     * @return void
     */
    public function __unset($opt)
    {
        // Since we really can't reset a CURLOPT_* to its
        // default value without knowing the default value,
        // just do nothing.
    }

    /**
     * Grants access to {@link CUrl::$ch $ch} to a {@link CUrlParallel} object.
     *
     * @param CUrlParallel $mh The CUrlParallel object that needs {@link CUrl::$ch $ch}.
     */
    public function grant(CUrlParallel $mh)
    {
        $mh->accept($this->ch);
        $this->multi = true;
    }

    /**
     * Removes access to {@link CUrl::$ch $ch} from a {@link CUrlParallel} object.
     *
     * @param CUrlParallel $mh The CUrlParallel object that no longer needs {@link CUrl::$ch $ch}.
     */
    public function revoke(CUrlParallel $mh)
    {
        $mh->release($this->ch);
        $this->multi = false;
    }

}
