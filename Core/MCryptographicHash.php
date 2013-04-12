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

require_once __DIR__.'/Enum/Algorithm.php';

use MToolkit\Core\Enum\Algorithm;

class MCryptographicHash
{
    private $algorith;
    
    /**
     * 
     * @param Algorithm $algorith
     */
    public function __construct( $algorith )
    {
        $this->algorith=$algorith;
    }
    
    /**
     * Return the hash of the <i>$text</i>.
     * 
     * @param string $text
     * @return string
     */
    public function getHash( $text )
    {
        return hash($this->algorith, $text);
    }
    
    /**
     * Return the hash of the file at <i>$filePath</i>.
     * 
     * @param string $filePath
     * @return string
     */
    public function getFileHash( $filePath )
    {
        return hash_file($this->algorith, $filePath);
    }
    
    /**
     * Return current algorithm.
     * 
     * @return string
     */
    public function getAlgorith()
    {
        return $this->algorith;
    }
}