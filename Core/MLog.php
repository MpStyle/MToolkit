<?php
namespace MToolkit\Core;

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

class MLog
{
    const INFO="info";
    const WARNING="warning";
    const ERROR="error";
    
    /**
     * @var MLogMessage[]
     */
    private static $messages=array();
    
    /**
     * @param string $tag
     * @param string $text
     */
    public static function i( $tag, $text )
    {
        $message=new MLogMessage();
        $message->setType(MLog::INFO)
                ->setTag($tag)
                ->setText($text);
        
        MLog::$messages[]=$message;
    }
    
    /**
     * @param string $tag
     * @param string $text
     */
    public static function w( $tag, $text )
    {
        $message=new MLogMessage();
        $message->setType(MLog::WARNING)
                ->setTag($tag)
                ->setText($text);
        
        MLog::$messages[]=$message;
    }
    
    /**
     * @param string $tag
     * @param string $text
     */
    public static function e( $tag, $text )
    {
        $message=new MLogMessage();
        $message->setType(MLog::ERROR)
                ->setTag($tag)
                ->setText($text);
        
        MLog::$messages[]=$message;
    }
    
    public static function printAll()
    {
        $template='<tr>
                <td style="color: %s">
                    %s
                </td>
                <td style="color: %s">
                    %s
                </td>
                <td style="color: %s">
                    %s
                </td>
            </tr>';
        $table="";
        
        foreach( MLog::$messages as /* @var $message MLogMessage */ $message )
        {
            $color="black";
            
            switch( $message->getType() )
            {
                case MLog::INFO:
                    $color="#008000";
                    break;
                case MLog::WARNING:
                    $color="#ffa500";
                    break;
                case MLog::ERROR:
                    $color="#ff0000";
                    break;
            }
            
            $table.=sprintf( 
                    $template
                    , $color
                    , $message->getTime()
                    , $color
                    , $message->getTag()
                    , $color
                    , $message->getText() );
        }
        
        $table= sprintf(
            '<table style="background: #000;">
                %s
            </table>'
            , $table);
        
        echo $table;
    }
}

/**
 * @ignore
 * <b>Don't use this class.</b>
 * It is used only from <i>MLog</i> class.
 */
class MLogMessage
{
    private $type;
    private $tag;
    private $text;
    private $time;
    
    public function __construct()
    {
        $this->time=new \DateTime();
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
        return $this;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag( $tag )
    {
        $this->tag = $tag;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText( $text )
    {
        $this->text = $text;
        return $this;
    }

    public function getTime()
    {
        return $this->time;
    }
}
