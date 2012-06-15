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

require_once 'MToolkit/Model/Sql/MDbConnection.php';

class MSettings
{

    public static function load()
    {
        $doc = new DOMDocument();
        $doc->load("settings.xml");

        foreach ($doc->childNodes as $settings)
        {
            if ($settings->hasChildNodes())
            {
                foreach ($settings->childNodes as $setting)
                {
                    switch ($setting->nodeName)
                    {
                        case "constant":
                            if ($setting->hasAttributes())
                            {
                                foreach ($setting->attributes as $attr)
                                {
                                    switch ($attr->nodeName)
                                    {
                                        case "name":
                                            $name = $attr->nodeValue;
                                            break;
                                        case "value":
                                            $value = $attr->nodeValue;
                                            break;
                                    }
                                }

                                if( $name!="" && $value!="" )
                                {
                                    define($name, $value);
                                }
                            }
                            break;
                        case "db_connection":
                            if ($setting->hasAttributes())
                            {
                                foreach ($setting->attributes as $attr)
                                {
                                    switch ($attr->nodeName)
                                    {
                                        case "name":
                                            $name = $attr->nodeValue;
                                            break;
                                        case "host":
                                            $host = $attr->nodeValue;
                                            break;
                                        case "username":
                                            $username = $attr->nodeValue;
                                            break;
                                        case "password":
                                            $password = $attr->nodeValue;
                                            break;
                                        case "database_name":
                                            $database_name = $attr->nodeValue;
                                            break;
                                    }
                                }

                                $conn = new mysqli($host, $username, $password, $database_name);

                                if ($name == "")
                                {
                                    DbConnection::addDbConnection($conn);
                                }
                                else
                                {
                                    DbConnection::addDbConnection($conn, $name);
                                }
                            }

                            break;
                    }
                }
            }
        }
    }

}

?>
