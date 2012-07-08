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
 * along with MToolkit.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

require_once 'MToolkit/Model/Sql/MDbConnection.php';

class MSettings
{

    public static function load()
    {
        if( file_exists("settings.json")===false )
        {
            return;
        }
        
        $settingsFileContent= file_get_contents("settings.json");
        $settings=json_decode($settingsFileContent,true);
        
        // Read constants
        foreach( $settings["constants"] as $constant )
        {
            if( $key!="" )
            {
                define($constant["key"], $constant["value"]);
            }
        }
        
        // Read db connection
        foreach( $settings["db_connections"] as $connection )
        {
            $conn=null;
            
            switch( $connection["type"] )
            {
                case "mysql":
                    $conn = new mysqli($connection["host"], $connection["username"], $connection["password"], $connection["database"]);
                    break;
                case "sqlite":
                    $conn = new SQLiteDatabase($connection["database"]);
                    break;
            }
            
            if ($connection["name"] == "")
            {
                DbConnection::addDbConnection($conn);
            }
            else
            {
                DbConnection::addDbConnection($conn, $connection["name"]);
            }
        }
    }

}

?>
