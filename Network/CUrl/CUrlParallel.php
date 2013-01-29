<?php

namespace MToolkit\Network\CUrl;

/**
 * Implements parallel-processing for cURL requests.
 *
 * The PHP cURL library allows two or more requests to run in
 * parallel (at the same time). If you have multiple requests
 * that may have high latency but can then be processed quickly
 * in series (one after the other), then running them at the
 * same time may save time, overall.
 *
 * You must create individual {@link CUrl} objects first, add them to
 * the CUrlParallel object, execute the CUrlParallel object,
 * then get the data from the individual {@link CUrl} objects. (Yes,
 * it's annoying, but it's limited by the PHP cURL library.)
 *
 * For example:
 *
 * <code>
 * $a = new CUrl("http://www.yahoo.com/");
 * $b = new CUrl("http://www.microsoft.com/");
 *
 * $m = new CUrlParallel($a, $b);
 *
 * $m->exec(); // Now we play the waiting game.
 *
 * printf("Yahoo is %n characters.\n", strlen($a->fetch()));
 * printf("Microsoft is %n characters.\n", strlen($b->fetch()));
 * </code>
 *
 * You can add any number of {@link CUrl} objects to the
 * CUrlParallel object's constructor (including 0), or you
 * can add with the {@link add()} method:
 *
 * <code>
 * $m = new CUrlParallel;
 *
 * $a = new CUrl("http://www.yahoo.com/");
 * $b = new CUrl("http://www.microsoft.com/");
 *
 * $m->add($a);
 * $m->add($b);
 *
 * $m->exec(); // Now we play the waiting game.
 *
 * printf("Yahoo is %n characters.\n", strlen($a->fetch()));
 * printf("Microsoft is %n characters.\n", strlen($b->fetch()));
 * </code>
 */
class CUrlParallel
{

    /**
     * Store the cURL master resource.
     * @var resource
     */
    protected $mh;

    /**
     * Store the resource handles that were
     * added to the session.
     * @var array
     */
    protected $ch = array();

    /**
     * Initialize the multisession handler.
     *
     * @uses add()
     * @param CUrl $curl,... {@link CUrl} objects to add to the Parallelizer.
     * @return CUrlParallel
     */
    public function __construct()
    {
        $this->mh = curl_multi_init();

        foreach (func_get_args() as $ch)
        {
            $this->add($ch);
        }

        return $this;
    }

    /**
     * On destruction, frees resources.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Close the current session and free resources.
     */
    public function close()
    {
        foreach ($this->ch as $ch)
        {
            curl_multi_remove_handle($this->mh, $ch);
        }
        curl_multi_close($this->mh);
    }

    /**
     * Add a {@link CUrl} object to the Parallelizer.
     *
     * Will throw a catchable fatal error if passed a non-CUrl object.
     *
     * @uses CUrl::grant()
     * @uses CUrlParallel::accept()
     * @param CUrl $ch CUrl object.
     */
    public function add(CUrl $ch)
    {
        // get the protected resource
        $ch->grant($this);
    }

    /**
     * Remove a {@link CUrl} object from the Parallelizer.
     *
     * @param CUrl $ch CUrl object.
     * @uses CUrl::revoke()
     * @uses CUrlParallel::release()
     */
    public function remove(CUrl $ch)
    {
        $ch->revoke($this);
    }

    /**
     * Execute the parallel cURL requests.
     */
    public function exec()
    {
        do
        {
            curl_multi_exec($this->mh, $running);
        } while ($running > 0);
    }

    /**
     * Accept a resource handle from a {@link CUrl} object and
     * add it to the master.
     *
     * @param resource $ch A resource returned by curl_init().
     */
    public function accept($ch)
    {
        $this->ch[] = $ch;
        curl_multi_add_handle($this->mh, $ch);
    }

    /**
     * Accept a resource handle from a {@link CUrl} object and
     * remove it from the master.
     *
     * @param resource $ch A resource returned by curl_init().
     */
    public function release($ch)
    {
        if (false !== $key = array_search($this->ch, $ch))
        {
            unset($this->ch[$key]);
            curl_multi_remove_handle($this->mh, $ch);
        }
    }

}
