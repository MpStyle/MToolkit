<?php
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
