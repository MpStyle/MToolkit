<?php
namespace MToolkit\Model\Sql;

require_once __DIR__ . '/MDbConnection.php';
require_once __DIR__ . '/MPDOResult.php';
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

class MPDOQuery extends MAbstractSqlQuery
{    
    /**
     * @var int[]|string[]|double[]
     */
    private $bindedValues=array();
    
    /**
     * @var MPDOResult
     */
    private $result=null;
    
    /**
     * @param string $query
     * @param \PDO $connection
     */
    public function __construct( $query=null, \PDO $connection=null )
    {
        $this->setQuery($query)
                ->setConnection($connection);
        
        if( $this->getConnection()==null )
        {
            $this->setConnection( MDbConnection::dbConnection() );
        }
    }
    
    /**
     * @return \PDO
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
        /* @var $sqlStmt \PDOStatement */ $sqlStmt=$this->getConnection()->prepare( $this->getQuery() );
        
        if( $sqlStmt===false )
        {
            parent::setError($this->getConnection()->errorInfo());
            parent::setErrorCode($this->getConnection()->errorCode());
            return false;
        }
        
        // Bind input
        if( count( $this->bindedValues )>0 )
        {
            foreach( $this->bindedValues as /* @var $i int */ $i => $bindedValue )
            {
                if(is_int($bindedValue))
                {
                    $type = PDO::PARAM_INT;
                }
                elseif(is_bool($bindedValue))
                {
                    $type = PDO::PARAM_BOOL;
                }
                elseif(is_null($bindedValue))
                {
                    $type = PDO::PARAM_NULL;
                }
                elseif(is_string($bindedValue))
                {
                    $type = PDO::PARAM_STR;
                }
                else
                {
                    $type = false;
                }
                    
                if($type)
                {
                    $bindParamsResult=$sqlStmt->bindValue($i,$bindedValue,$type);
                    
                    if( $bindParamsResult===false )
                    {
                        parent::setError($sqlStmt->errorInfo());
                        parent::setErrorCode($sqlStmt->errorCode());

                        return false;
                    }
                }
            }
        }
                
        // Exec query
        $result=$sqlStmt->execute();
        
        if( $result==false )      
        {
            parent::setError($sqlStmt->errorInfo());
            parent::setErrorCode($sqlStmt->errorCode());
            
            return false;
        }
                
        $this->result=new MMysqliResult($sqlStmt);
                
        return true;
    }

    /**
     * @return MPDOResult
     */
    public function getResult()
    {
        return $this->result;
    }


}

