<?php

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

namespace MToolkit\Core;

require_once __DIR__ . '/Enum/HashAlgorithm.php';

use MToolkit\Core\Enum\HashAlgorithm;

class MHash
{
    private $hashAlgorithm;

    /**
     * @param HashAlgorithm $hashAlgorithm
     * 
     * @throws \Exception Thrown when the <i>$hashAlgorithm</i> is not supported.
     */
    public function __construct($hashAlgorithm)
    {
        if (in_array($hashAlgorithm, hash_algos()) == false)
        {
            throw new \Exception("Algorithm " . $hashAlgorithm . " not supported.");
        }

        $this->hashAlgorithm = $hashAlgorithm;
    }

    public function getHash($text)
    {
        return hash($this->hashAlgorithm, $text);
    }

}
