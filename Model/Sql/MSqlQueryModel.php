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

require_once __DIR__.'/../MAbstractDataModel.php';
require_once __DIR__.'/MAbstractSqlQuery.php';
require_once __DIR__.'/MMysqliQuery.php';
require_once __DIR__.'/MAbstractSqlQuery.php';
require_once __DIR__.'/../../Core/MObject.php';

use MToolkit\Core\MObject;
use MToolkit\Model\MAbstractDataModel;
use MToolkit\Model\Sql\MAbstractSqlQuery;

class MSqlQueryModel extends MAbstractDataModel
{
    /**
     * @var MAbstractSqlQuery 
     */
    private $query;
    
    public function __construct( MObject $parent=null )
    {
        parent::__construct($parent);
    }

    public function setQuery( $query, $db = null )
    {
        if( $db==null )
        {
            $db= MDbConnection::dbConnection();
        }
        
        if( $db instanceof \PDO )
        {
            $this->query=new MPDOQuery($query, $db);
        }
        else if( $db instanceof \mysqli )
        {
            $this->query=new MMysqliQuery($query, $db);
        }
        else
        {
            throw new Exception("Database connection not supported.");
        }
        
        $this->query->exec();
    }
    
    public function columnCount()
    {
        return $this->query->getResult()->columnCount();
    }

    public function getData($row, $column)
    {
        return $this->query->getResult()->getData($row, $column);
    }

    public function rowCount()
    {
        return $this->query->getResult()->rowCount();
    }
}