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

class MVectorIterator implements \Iterator
{

    /**
     * @var MVector
     */
    private $vector;

    /**
     * @var integer
     */
    private $pos = 0;

    public function __construct( MVector $vector )
    {
        $this->vector = $vector;
    }

    public function current()
    {
        return $this->vector->at( $this->pos );
    }

    public function key()
    {
        return null;
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
        return ( $this->pos >= 0 && $this->pos < $this->vector->count() );
    }

}
