<?php
namespace MToolkit\Core\Cache;

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

require_once __DIR__.'/MAbstractCache.php';

class MSQLiteCache extends MAbstractCache
{
    private $connection;
    private $cacheTableName;

    public function __construct( \PDO $connection, $cacheTableName = 'MToolkitCache', \MToolkit\Core\MObject $parent = null )
    {
        parent::__construct( $parent );

        if( $connection->getAttribute( \PDO::ATTR_DRIVER_NAME )!='sqlite' )
        {
            throw new Exception( 'Invalid database connection, required sqlite, passed ' . $connection->getAttribute( \PDO::ATTR_DRIVER_NAME ) );
        }

        $this->connection = $connection;
        $this->cacheTableName = $cacheTableName;
        $this->init();
    }

    private function init()
    {
        $query = "CREATE TABLE `" . $this->cacheTableName . "`
            (
                `Key` TEXT PRIMARY KEY,
                `Value` BLOB,
                `Expired` INTEGER
            );
        ";
        /* @var $connection \PDO */ $connection = MDbConnection::dbConnection();
        /* @var $stmt \PDOStatement */ $stmt = $connection->prepare( $query );
        /* @var $result bool */ $result = $stmt->execute();

        if( $result===false )
        {
            throw new \Exception( json_encode( $stmt->errorInfo() ) );
        }

        $stmt->closeCursor();
    }

    public function delete( $key )
    {
        $query = "DELETE FROM `" . $this->cacheTableName . "`
            WHERE `Key`=?;
        ";
        /* @var $connection \PDO */ $connection = MDbConnection::dbConnection();
        /* @var $stmt \PDOStatement */ $stmt = $connection->prepare( $query );
        /* @var $result bool */ $result = $stmt->execute( array( $key ) );

        if( $result===false )
        {
            throw new \Exception( json_encode( $stmt->errorInfo() ) );
        }

        $stmt->closeCursor();
    }

    public function flush()
    {
        $query = "TRUNCATE TABLE `" . $this->cacheTableName . "`;";
        /* @var $connection \PDO */ $connection = MDbConnection::dbConnection();
        /* @var $stmt \PDOStatement */ $stmt = $connection->prepare( $query );
        /* @var $result bool */ $result = $stmt->execute();

        if( $result===false )
        {
            throw new \Exception( json_encode( $stmt->errorInfo() ) );
        }

        $stmt->closeCursor();
    }

    public function set( $key, $value, $expired = -1 )
    {
        $this->delete( $key );

        $query = "INSERT INTO `" . $this->cacheTableName . "` (`Key`, `Value`, `Expired`)
            VALUES(?, ?, ?)
        ;";
        /* @var $connection \PDO */ $connection = MDbConnection::dbConnection();
        /* @var $stmt \PDOStatement */ $stmt = $connection->prepare( $query );
        /* @var $result bool */ $result = $stmt->execute( array( $key, serialize($value), $expired ) );

        if( $result===false )
        {
            throw new \Exception( json_encode( $stmt->errorInfo() ) );
        }

        $stmt->closeCursor();
    }

    /**
     * Return the content of a cache record with <i>$key</i>.
     * 
     * @param string $key
     * @return string|null
     */
    public function get( $key )
    {
        $query = "SELECT `Key`, `Value`, `Expired` FROM `" . $this->cacheTableName . "` WHERE `key`=?;";
        /* @var $connection \PDO */ $connection = MDbConnection::dbConnection();
        /* @var $stmt \PDOStatement */ $stmt = $connection->prepare( $query );
        /* @var $result bool */ $result = $stmt->execute( array($key) );
        
        if ( $result === false )
        {
            throw new \Exception( json_encode(  $stmt->errorInfo() ) );
        }
        
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        if( count($rows)<=0 )
        {
            return null;
        }
        
        $key=$rows[0]['Key'];
        $value=$rows[0]['Value'];
        $expired=$rows[0]['Expired'];
        
        if( $expired==-1 || $expired > time() )
        {
            return unserialize($value);
        }
        
        $this->delete($key);
        return null;
    }
}

