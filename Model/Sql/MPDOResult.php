<?php
namespace MToolkit\Model\Sql;

require_once __DIR__.'/MAbstractSqlResult.php';

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

class MPDOResult extends MAbstractSqlResult
{    
    /**
     * Contains the names of the fields.
     * 
     * @var array
     */
    private $fields=array();
    
    private $statement;

    /**
     * @param \mysqli_stmt $statement
     */
    public function __construct( \PDOStatement $statement )
    {               
        $this->statement=$statement;
        
        $rows = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        $this->fields = empty($rows) ? array() : array_keys( (array) $rows[0] );
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
     * @return type
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
        /* @var $pdoResult array */ $pdoResult=$this->statement->fetchAll();
        
        return $pdoResult[$row][$column];
    }
}
