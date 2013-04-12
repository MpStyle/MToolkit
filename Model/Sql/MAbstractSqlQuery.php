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

abstract class MAbstractSqlQuery
{
    /**
     * @var string 
     */
    private $query;
    
    /**
     * @var mixed The connection to db.
     */
    private $connection;
    
    private $error;
    private $errorCode;
    
    /**
     * @return bool The correct execution of the query.
     */
    public abstract function exec();
    
    /**
     * @return MAbstractSqlResult The resultset of the query, if exists.
     */
    public abstract function getResult();

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return \MToolkit\Model\Sql\MAbstractSqlQuery
     */
    public function setQuery( $query )
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     * @return \MToolkit\Model\Sql\MAbstractSqlQuery
     */
    protected function setConnection( $connection )
    {
        $this->connection = $connection;
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    protected function setError( $error )
    {
        $this->error = $error;
        return $this;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    protected function setErrorCode( $errorCode )
    {
        $this->errorCode = $errorCode;
        return $this;
    }


}

