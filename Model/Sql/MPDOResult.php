<?php

namespace MToolkit\Model\Sql;

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

require_once __DIR__ . '/MAbstractSqlResult.php';
require_once __DIR__ . '/MSqlRecord.php';
require_once __DIR__ . '/MSql.php';
require_once __DIR__ . '/../../Core/Exception/MReadOnlyObjectException.php';

use MToolkit\Model\Sql;
use MToolkit\Model\Sql\MSqlRecord;
use MToolkit\Core\Exception\MReadOnlyObjectException;

class MPDOResult extends MAbstractSqlResult
{

    /**
     * Contains the names of the fields.
     * 
     * @var array
     */
    private $fields = array();

    /**
     * @var \PDOStatement
     */
    private $statement;
    
    /**
     * @var int
     */
    private $at = 0;
    
    /**
     * @var array
     */
    private $rows=null;

    /**
     * @param \PDOStatement $statement
     * @param \MToolkit\Model\Sql\MObject $parent
     */
    public function __construct( \PDOStatement $statement, MObject $parent = null )
    {
        parent::__construct($parent);

        $this->statement = $statement;

        $this->rows = $this->statement->fetchAll( \PDO::FETCH_ASSOC );
        $this->fields = empty( $this->rows ) ? array() : array_keys( ( array ) $this->rows[ 0 ] );
    }

    /**
     * Return the number of rows in resultset.
     * 
     * @return int
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * Return the number of columns in resultset.
     * 
     * @return int
     */
    public function columnCount()
    {
        return $this->statement->columnCount();
    }

    /**
     * Return an array contains the names of the fields.
     * 
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Return the data at the <i>row</i> and <i>column</i>.
     * 
     * @param int $row
     * @param int|string $column
     */
    public function getData( $row, $column )
    {
        return $this->rows[ $row ][ $column ];
    }

    public function getNumRowsAffected()
    {
        return $this->statement->rowCount();
    }

    /**
     * Returns the current record if the query is active; otherwise returns an empty QSqlRecord. <br />
     * The default implementation always returns an empty QSqlRecord.
     * 
     * @return \MToolkit\Model\Sql\MSqlRecord
     */
    public function getRecord()
    {
        return new MSqlRecord( $this->rows[ $this->at ] );
    }

    /**
     * Returns the current (zero-based) row position of the result. May return 
     * the special values MSql\Location::BeforeFirstRow or MSql\Location::AfterLastRow.
     * 
     * @return int
     */
    public function getAt()
    {
        if ( $this->at < 0 )
        {
            return MSql\Location::BeforeFirstRow;
        }

        if ( $this->at > $this->rowCount() )
        {
            return MSql\Location::AfterLastRow;
        }

        return $this->at;
    }

    /**
     * This function is provided for derived classes to set the internal 
     * (zero-based) row position to <i>$at</i>.
     * 
     * @param int $at
     * @return \MToolkit\Model\Sql\MPDOResult
     */
    public function setAt( $at )
    {
        $this->at = $at;
        return $this;
    }

    public function current()
    {
        return $this->rows[$this->getAt()];
    }

    public function key()
    {
        return $this->getAt();
    }

    public function next()
    {
        $this->at++;
    }

    public function offsetExists( $offset )
    {
        return (array_key_exists($offset, $this->rows)===true);
    }

    public function offsetGet( $offset )
    {
        if( $this->offsetExists($offset) )
        {
            return $this->rows[$offset];
        }
        
        return null;
    }

    public function offsetSet( $offset, $value )
    {
        throw new MReadOnlyObjectException(__CLASS__, __METHOD__);
    }

    public function offsetUnset( $offset )
    {
        throw new MReadOnlyObjectException(__CLASS__, __METHOD__);
    }

    public function rewind()
    {
        $this->at = 0;
    }

    public function valid()
    {
        return ( $this->at >= 0 && $this->at < $this->rowCount() );
    }
    
    public function toArray()
    {
        return $this->rows;
    }

}
