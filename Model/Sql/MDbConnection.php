<?php
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
 * along with Nome-Programma.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

class MDbConnection
{
    private $connection=null;
    private static $istance=null;

    private function  __construct()
    {
        $this->connection=array();
    }

    public static function dbConnection( /* string */ $name="DefaultConnection" )
    {
        if( is_null( MDbConnection::$istance ) )
            return null;

        return MDbConnection::$istance->connection[$name];
    }

    public static function addDbConnection( /* mixed */ $connection
                                          , /* string */ $name="DefaultConnection" )
    {
        if( is_null( MDbConnection::$istance ) )
            MDbConnection::$istance=new MDbConnection();

        MDbConnection::$istance->connection[$name]=$connection;
    }

    public static function removeDbConnection( /* string */ $name="DefaultConnection" )
    {
        if( is_null( MDbConnection::$istance ) )
            return;

        MDbConnection::$istance->connection[$name]=null;
    }
}

