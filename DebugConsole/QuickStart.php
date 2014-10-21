<?php

namespace MToolkit\DebugConsole;

require_once __DIR__ . '/Settings.php';

use MToolkit\Controller\MAbstractPageController;
use MToolkit\DebugConsole\MasterPages\MainMasterPage;
use MToolkit\DebugConsole\Languages\Languages;

class QuickStart extends MAbstractPageController
{

    public function __construct()
    {
        parent::__construct( __DIR__ . '/QuickStart.view.php' );
        parent::setMasterPage( new MainMasterPage( $this ) );
        parent::addMasterPagePart( "Content", "Content" );
        parent::setPageTitle( Languages::getString( "menu_item_quick_start" ) . " - " . Languages::getString( "mtoolkit" ) );
    }

}
