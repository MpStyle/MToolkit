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

class MElementIdNotFoundException extends \Exception
{
    public function __construct($fileName, $idElement, $code=-1, \Exception $previous=null) 
    {
        parent::__construct("The element with id '" . $idElement . "' was not founded in the file '" . $fileName . "'.", $code, $previous);
    }
}
