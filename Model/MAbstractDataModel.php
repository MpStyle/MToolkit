<?php
namespace MToolkit\Model;

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

require_once __DIR__.'/../Core/MObject.php';

use MToolkit\Core\MObject;

abstract class MAbstractDataModel extends MObject
{
    public function __construct( MObject $parent=null )
    {
        parent::__construct( $parent );
    }
    
    /**
     * Return the number of rows in resultset.
     * 
     * @return int
     */
    public abstract function rowCount();
    
    /**
     * Return the number of columns in resultset.
     * 
     * @return int
     */
    public abstract function columnCount();
    
    /**
     * Return the data at the <i>row</i> and <i>column</i>.
     * 
     * @param int $row
     * @param mixed $column
     */
    public abstract function getData( $row, $column );
}
