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

class MLog
{
    private static $messages=array();
    
    public static function i( $tag, $text )
    {
        $time = new DateTime();
        
        MLog::$messages[]=array($time->format('Y-m-d H:i:s'), $tag, $text);
    }
    
    public static function toHtml()
    {
        $html="";
        
        foreach( MLog::$messages as $message )
        {
            $html.=$message[0] . " - " . $message[1] . " - " . $message[2] . "\n";
        }
        
        $html='
            <div style="background: black; color: white;">
                <strong style="color: #fff;">LOGS</strong>
                <textarea style="width: 100%;" rows="10">'.
                    $html.'
                </textarea>
            </div>';
        
        return $html;
    }
}

?>
