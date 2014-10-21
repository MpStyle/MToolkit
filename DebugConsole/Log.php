<?php

namespace MToolkit\DebugConsole;

require_once __DIR__ . '/Settings.php';

use MToolkit\Controller\MAbstractPageController;
use MToolkit\DebugConsole\MasterPages\MainMasterPage;
use MToolkit\Core\MLog;
use MToolkit\Core\MCoreApplication;
use MToolkit\DebugConsole\Languages\Languages;

class Log extends MAbstractPageController
{
    public function __construct()
    {
        parent::__construct( __DIR__ . '/Log.view.php' );
        parent::setMasterPage( new MainMasterPage( $this ) );
        parent::addMasterPagePart( "Content", "Content" );
        parent::setPageTitle( Languages::getString( "menu_item_log" ) . " - " . Languages::getString( "mtoolkit" ) );
                
        if( !$this->isPostBack() )
        {
            return;
        }

        // To do only if it is postback
        switch( $this->getPost()->getValue( "action" ) )
        {
            case "ClearLogMessages":
                MLog::clearAllMessages();
                break;
            case "DisableDebug":
                MCoreApplication::setIsDebug(false);
                break;
            case "EnableDebug":
                MCoreApplication::setIsDebug(true);
                break;
        }
    }

    /**
     * @param string $mlogMessageType
     * @return string
     */
    public static function getBootstrapTdClass( $mlogMessageType )
    {
        switch( $mlogMessageType )
        {
            case MLog::ERROR:
                return "danger";
                break;
            case MLog::INFO:
                return "success";
                break;
            case MLog::WARNING:
                return "warning";
                break;
        }
        
        return "";
    }
}
