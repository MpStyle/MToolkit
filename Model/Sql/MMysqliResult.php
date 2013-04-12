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

class MMysqliResult extends MAbstractSqlResult
{
    /**
     * The resultset.
     * 
     * @var array 
     */
    private $result = array( );
    
    /**
     * Contains the names of the fields.
     * 
     * @var array
     */
    private $fileds=array();

    /**
     * @param \mysqli_stmt $statement
     */
    public function __construct( \mysqli_stmt $statement )
    {               
        $meta = $statement->result_metadata();

        if( $meta==false )
        {
            return;
        }
        
        while ( $field = $meta->fetch_field() )
        {
            $params[] = &$row[$field->name];
            $this->fileds[]=$field->name;
        }

        call_user_func_array( array( $statement, 'bind_result' ), $params );
        while ( $statement->fetch() )
        {
            foreach ( $row as $key => $val )
            {
                $c[$key] = $val;
            }
            $this->result[] = $c;
        }
    }

    /**
     * Return the number of rows in resultset.
     * 
     * @return int
     */
    public function rowCount()
    {
        return count( $this->result );
    }
    
    /**
     * Return the number of columns in resultset.
     * 
     * @return int
     */
    public function columnCount()
    {
        return count( $this->getFields() );
    }
    
    /**
     * Return an array contains the names of the fields.
     * 
     * @return type
     */
    public function getFields()
    {
        return $this->fileds;
    }
    
    /**
     * Return the data at the <i>row</i> and <i>column</i>.
     * 
     * @param int $row
     * @param int|string $column
     */
    public function getData( $row, $column )
    {
        $field=$column;
        
        if( is_int( $field ) )
        {
            $fields=$this->getFields();
            $field=$fields[$field];
        }
        
        return $this->result[$row][$field];
    }
    
    /**
     * Return the resultset as array.
     * 
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}
