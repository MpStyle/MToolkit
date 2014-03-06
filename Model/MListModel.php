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

require_once __DIR__ . '/../Core/MObject.php';
require_once __DIR__ . '/../Core/MList.php';
require_once __DIR__ . '/MAbstractDataModel.php';

use MToolkit\Core\MObject;
use MToolkit\Model\MAbstractDataModel;
use MToolkit\Core\MList;

class MListModel extends MAbstractDataModel
{

    /**
     * @var MList
     */
    private $data = null;

    /**
     * @param MList|array|null $array
     * @param \MToolkit\Core\MObject $parent
     */
    public function __construct(MObject $parent = null)
    {
        parent::__construct($parent);

        $this->data=new MList();
    }

    public function setDataFromArray( array $data )
    {
        $this->data->fromArray($data);
    }
    
    /**
     * Return the number of rows in resultset.
     * 
     * @return int
     */
    public function rowCount()
    {
        return $this->data->size();
    }

    /**
     * Return the number of columns in resultset.
     * 
     * @return int
     */
    public function columnCount()
    {
        return 1;
    }

    /**
     * Return the data at the <i>row</i> and <i>column</i>.
     * 
     * @param int $row
     * @param int $column
     */
    public function getData($row, $column = 0)
    {
        return $this->data->at($row);
    }
    
    /**
     * Returns the data for the given <i>$section</i> in the header with the specified <i>$orientation</i>.
     * 
     * @param int|string $section
     * @param int|Orientation $orientation
     * @return null
     */
    public function getHeaderData( $section, $orientation )
    {
        $headerData = null;

        if( count( $this->data )>0 )
        {
            return $headerData;
        }

        switch( $orientation )
        {
            case Orientation::Horizontal:
                break;
            case Orientation::Vertical:
                $fields = array_keys( $this->data );
                $headerData = $fields[$section];
                break;
        }

        return $headerData;
    }

    /**
     * Sets the data for the given <i>$section</i> in the header with the specified <i>$orientation</i> to the value supplied.<br />
     * Returns true if the header's data was updated; otherwise returns false.
     * 
     * @param int|string $section
     * @param int|Orientation $orientation
     * @param mixed $value
     * @return false
     */
    public function setHeaderData( $section, $orientation, $value )
    {
        $toReturn = false;

        if( count( $this->data )>0 )
        {
            return $toReturn;
        }

        switch( $orientation )
        {
            case Orientation::Horizontal:
                break;
            case Orientation::Vertical:
                $fields = array_keys( $this->data );
                $values = array_values( $this->data );
                $fields[$section] = $value;
                $this->data = array_combine( $fields, $values );
                $toReturn = true;
                break;
        }

        return $toReturn;
    }

}

