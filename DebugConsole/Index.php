<?php

namespace MToolkit\DebugConsole;

require_once __DIR__ . '/Settings.php';

use MToolkit\Controller\MAbstractPageController;
use MToolkit\DebugConsole\MasterPages\MainMasterPage;
use MToolkit\DebugConsole\Languages\Languages;

class Index extends MAbstractPageController
{

    public function __construct()
    {
        parent::__construct( __DIR__ . '/Index.view.php' );
        parent::setMasterPage( new MainMasterPage( $this ) );
        parent::addMasterPagePart( "Content", "Content" );
        parent::setPageTitle( Languages::getString( "mtoolkit" ) );
    }

}
