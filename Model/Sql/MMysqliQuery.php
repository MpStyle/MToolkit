<?php
namespace MToolkit\Model\Sql;

require_once __DIR__ . '/MDbConnection.php';
require_once __DIR__ . '/MMysqliResult.php';
require_once __DIR__ . '/MAbstractSqlQuery.php';

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

class MMysqliQuery extends MAbstractSqlQuery
{    
    /**
     * @var int[]|string[]|double[]
     */
    private $bindedValues=array();
    
    /**
     * @var MMysqliResult
     */
    private $result=null;
    
    /**
     * @param string $query
     * @param \mysqli $connection
     */
    public function __construct( $query=null, \mysqli $connection=null )
    {
        $this->setQuery($query)
                ->setConnection($connection);
        
        if( $this->getConnection()==null )
        {
            $this->setConnection( MDbConnection::dbConnection() );
        }
    }
    
    /**
     * @return \mysqli
     */
    public function getConnection()
    {
        return parent::getConnection();
    }
    
    /**
     * @param string $query
     */
    public function prepare( $query )
    {
        $this->query=$query;
    }
    
    /**
     * Bind the <i>value</i> to query.
     * Call this method in order with the '<i>?</i>' in the sql statement.
     * 
     * @param int|string|double $value
     */
    public function bindValue( $value )
    {
        $this->bindedValues[]=$value;
    }
    
    /**
     * @return boolean
     */
    public function exec()
    {
        /* @var $sqlStmt \mysqli_stmt */ $sqlStmt=$this->getConnection()->prepare( $this->getQuery() );
        
        if( $sqlStmt===false )
        {
            parent::setError($this->getConnection()->error);
            parent::setErrorCode($this->getConnection()->errno);
            return false;
        }
        
        // Bind input
        if( count( $this->bindedValues )>0 )
        {
            $types='';
            
            foreach( $this->bindedValues as $bindedValue )
            {
                if( is_int( $bindedValue ) )
                {
                    $types.='i';
                }
                elseif( is_double( $bindedValue) )
                {
                    $types.='d';
                }
                // Else all is a string, null included
                else
                {
                    $types.='s';
                }
            }
            
            $params=array( $types );
            for( $i=0; $i<count($this->bindedValues); $i++ )
            {
                $params[$i+1]=&$this->bindedValues[$i];
            }
            
            $bindParamsResult = call_user_func_array(array( $sqlStmt, 'bind_param' ), $params);
                                    
            if( $bindParamsResult===false )
            {
                parent::setError($sqlStmt->error);
                parent::setErrorCode($sqlStmt->errno);
                
                return false;
            }
        }
                
        // Exec query
        $result=$sqlStmt->execute();
        
        if( $result==false )      
        {
            parent::setError($sqlStmt->error);
            parent::setErrorCode($sqlStmt->errno);
            
            $sqlStmt->close();
            
            return false;
        }
        
        // Get result
        $sqlStmt->store_result();
        
        $this->result=new MMysqliResult($sqlStmt);
        
        $sqlStmt->free_result();
        $sqlStmt->close();
                
        return true;
    }

    /**
     * @return MMysqliResult
     */
    public function getResult()
    {
        return $this->result;
    }


}

