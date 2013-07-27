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

require_once __DIR__.'/MAbstractDataModel.php';
require_once __DIR__.'/../Core/MObject.php';

use MToolkit\Core\MObject;

class MTableModel extends MAbstractDataModel
{
    private $data=array();
    
    public function __construct( MObject $parent = null )
    {
        parent::__construct( $parent );
    }
    
    public function setDataFromArray( array $data )
    {
        $this->data=$data;
    }
    
    public function columnCount()
    {
        if( $this->rowCount()<=0 )
        {
            return 0;
        }
        
        return count( $this->data[0] );
    }

    public function getData( $row, $column )
    {
        return $this->data[$row][$column];
    }

    public function rowCount()
    {
        return count( $this->data );
    }    
}
