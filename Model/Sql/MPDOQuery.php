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

/**
 * The QSqlQuery class provides a means of executing and manipulating SQL 
 * statements.
 */
class MPDOQuery extends MAbstractSqlQuery
{

    /**
     * @var int[]|string[]|double[]
     */
    private $bindedValues = array();

    /**
     * @var MPDOResult
     */
    private $result = null;

    /**
     * @param string $query
     * @param \PDO $connection
     */
    public function __construct( $query = null, \PDO $connection = null )
    {
        $this->setQuery( $query )
                ->setConnection( $connection );

        if ( $this->getConnection() == null )
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
     * Prepares the SQL query query for execution. Returns true if the query is 
     * prepared successfully; otherwise returns false.<br />
     * The query may contain placeholders for binding values. Both Oracle style 
     * colon-name (e.g., :surname), and ODBC style (?) placeholders are 
     * supported; but they cannot be mixed in the same query. See the Detailed 
     * Description for examples.<br />
     * Portability note: Some databases choose to delay preparing a query until 
     * it is executed the first time. In this case, preparing a syntactically 
     * wrong query succeeds, but every consecutive exec() will fail.<br />
     * For SQLite, the query string can contain only one statement at a time. If 
     * more than one statements are give, the function returns false.
     * 
     * @param string $query
     */
    public function prepare( $query )
    {
        $sqlStmt = $this->getConnection()->prepare( $query );

        if ( $sqlStmt == false )
        {
            return false;
        }

        $this->query = $query;
        return true;
    }

    /**
     * Bind the <i>value</i> to query.
     * Call this method in order with the '<i>?</i>' in the sql statement.
     * 
     * @param int|string|double|null $value
     */
    public function bindValue( $value )
    {
        $this->bindedValues[] = $value;
    }

    /**
     * 
     * @param mixed $value
     * @return \PDO::PARAM_INT|\PDO::PARAM_BOOL|\PDO::PARAM_NULL|\PDO::PARAM_STR
     */
    private function getPDOType( $value )
    {
        switch ( true )
        {
            case is_int( $value ):
                return \PDO::PARAM_INT;
            case is_bool( $value ):
                return \PDO::PARAM_BOOL;
            case is_null( $value ):
                return \PDO::PARAM_NULL;
            case is_string( $value ):
                return \PDO::PARAM_STR;
        }

        return false;
    }

    /**
     * Executes a previously prepared SQL query. Returns true if the query 
     * executed successfully; otherwise returns false.<br />
     * Note that the last error for this query is reset when exec() is called.
     * 
     * @return boolean
     */
    public function exec()
    {
        /* @var $sqlStmt \PDOStatement */ $sqlStmt = $this->getConnection()->prepare( $this->getQuery() );

        if ( $sqlStmt === false )
        {
            parent::setError( $this->getConnection()->errorInfo() );
            parent::setErrorCode( $this->getConnection()->errorCode() );
            return false;
        }

        // Bind input
        foreach ( $this->bindedValues as /* @var $i int */ $i => $bindedValue )
        {
            $type = $this->getPDOType( $bindedValue );

            if ( $type === false )
            {
                throw new Exception( 'Invalid type of binded value at position ' . $i . '.' );
            }

            $bindParamsResult = $sqlStmt->bindValue( $i, $bindedValue, $type );

            if ( $bindParamsResult === false )
            {
                parent::setError( $sqlStmt->errorInfo() );
                parent::setErrorCode( $sqlStmt->errorCode() );

                return false;
            }
        }

        // Exec query
        $result = $sqlStmt->execute();

        if ( $result == false )
        {
            parent::setError( $sqlStmt->errorInfo() );
            parent::setErrorCode( $sqlStmt->errorCode() );

            return false;
        }

        $this->result = new MPDOResult( $sqlStmt );

        return true;
    }

    /**
     * Returns the result associated with the query.
     * 
     * @return MPDOResult
     */
    public function getResult()
    {
        return $this->result;
    }

}
