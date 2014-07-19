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

require_once __DIR__ . '/MObject.php';

use MToolkit\Core\MObject;

/**
 * @const SIGNAL_INFORMATION_ENTERED This signal is emitted when an information message is added.
 * @const SIGNAL_ERROR_ENTERED This signal is emitted when an error message is added.
 * @const SIGNAL_WARNING_ENTERED This signal is emitted when an warning message is added.
 */
class MLog extends MObject
{
    const INFO = "INFO";
    const WARNING = "WARNING";
    const ERROR = "ERROR";

    /* SIGNALS */
    const SIGNAL_INFORMATION_ENTERED = "SIGNAL_INFORMATION_ENTERED";
    const SIGNAL_ERROR_ENTERED = "SIGNAL_ERROR_ENTERED";
    const SIGNAL_WARNING_ENTERED = "SIGNAL_WARNING_ENTERED";

    /**
     * @var MLogMessage[]
     */
    private $messages = array();

    /**
     * Add a information message.
     * 
     * @param string $tag
     * @param string $text
     */
    public function i( $tag, $text )
    {
        $message = new MLogMessage();
        $message->setType( MLog::INFO )
                ->setTag( $tag )
                ->setText( $text );

        $this->messages[] = $message;

        parent::emit( self::SIGNAL_INFORMATION_ENTERED );
    }

    /**
     * Add a warning message.
     * 
     * @param string $tag
     * @param string $text
     */
    public function w( $tag, $text )
    {
        $message = new MLogMessage();
        $message->setType( MLog::WARNING )
                ->setTag( $tag )
                ->setText( $text );

        $this->messages[] = $message;

        parent::emit( self::SIGNAL_WARNING_ENTERED );
    }

    /**
     * Add a error message.
     * 
     * @param string $tag
     * @param string $text
     */
    public function e( $tag, $text )
    {
        $message = new MLogMessage();
        $message->setType( MLog::ERROR )
                ->setTag( $tag )
                ->setText( $text );

        $this->messages[] = $message;

        parent::emit( self::SIGNAL_ERROR_ENTERED );
    }

    /**
     * Return the number of the message in log.
     * 
     * @return int
     */
    public function messageCount()
    {
        return count( $this->messages );
    }

    /**
     * Return the message at position <i>$i</i>.
     * 
     * @param int $i
     * @return boolean
     */
    public function getMessage( $i )
    {
        if( isset( $this->messages[$i] ) === false )
        {
            return false;
        }

        return $this->messages[$i];
    }

    /**
     * Print all messages in a HTML table ready to print on screen.
     */
    public function __toString()
    {
        $rowTemplate = '
            <tr style="background-color: %s" class="log">
                <td class="log_timestamp">
                    %s
                </td>
                <td class="log_tag">
                    %s
                </td>
                <td class="log_message">
                    %s
                </td>
            </tr>';
        $rows = "";

        foreach( $this->messages as /* @var $message MLogMessage */ $message )
        {
            $color = "black";

            switch( $message->getType() )
            {
                default:
                case MLog::INFO:
                    $color = "#00c500";
                    break;
                case MLog::WARNING:
                    $color = "#ffa500";
                    break;
                case MLog::ERROR:
                    $color = "#ff0000";
                    break;
            }

            $rows.=sprintf(
                    $rowTemplate
                    , $color
                    , $message->getTime()->format( 'Y-m-d H:i:s.u' )
                    , $message->getTag()
                    , $message->getText() );
        }

        $table = sprintf( '
            <table style="background: #000;" class="logs_table">
                %s
            </table>'
                , $rows );

        return $table;
    }

}

/**
 * <b>Don't istantiate an object of type MLogMessage.</b>
 * It is used only from <i>MLog</i> class to return a MLogMessage
 */
final class MLogMessage
{
    private $type;
    private $tag;
    private $text;
    private $time;

    public function __construct()
    {
        $this->time = new \DateTime();
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
