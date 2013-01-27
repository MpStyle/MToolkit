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

class MMapIterator implements \Iterator
{

    /**
     * @var MMap
     */
    private $map;

    /**
     * @var integer
     */
    private $pos = 0;

    public function __construct( MList $map )
    {
        $this->map = $map;
    }

    public function current()
    {
        $keys = $this->map->getKeys();

        return $this->map->value( $keys->at( $this->pos ), null );
    }

    public function key()
    {
        $keys = $this->map->getKeys();

        return $keys->at( $this->pos );
    }

    public function next()
    {
        $this->pos++;
    }

    public function rewind()
    {
        $this->pos = 0;
    }

    public function valid()
    {
        $keys = $this->map->getKeys();

        return ( $this->pos >= 0 && $this->pos < $keys->count() );
    }

}