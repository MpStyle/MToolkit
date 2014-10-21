<?php

namespace MToolkit\DebugConsole\MasterPages;

use MToolkit\Controller\MAbstractMasterPageController;
use MToolkit\Controller\MAbstractController;
use MToolkit\DebugConsole\Languages\Languages;

class MainMasterPage extends MAbstractMasterPageController
{

    public function __construct( MAbstractController $parent )
    {
        parent::__construct( __DIR__ . '/MainMasterPage.view.php', $parent );

        if( $this->getGet()->getValue( 'language' ) != null )
        {
            Languages::setCurrentLanguage( $this->getGet()->getValue( 'language' ) );
        }
    }

}
