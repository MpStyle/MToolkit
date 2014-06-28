<?php

namespace MToolkit\Core\Exception;

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

class MWrongTypeException extends \InvalidArgumentException
{

    public function __construct( $varName, $typeRequired, $given, $code = -1, \Exception $previous = null )
    {
        $typeGiven = gettype( $given );

        if ($typeGiven == 'object')
        {
            $typeGiven = get_class( $given );
        }

        parent::__construct( "Wrong type exception for $varName: $typeRequired required, " . $typeGiven . " given.", $code, $previous );
    }

}
