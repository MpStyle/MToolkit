<?php
require_once 'MToolkit/View/MControl.php';

class MTextHtmlControl extends MControl
{
    private $value=null;
    
    public function __construct( $value )
    {
        parent::__construct();
        
        $this->value=$value;
    }
    
    public function render( &$output )
    {
        $output.=$this->value;
    }

    protected function init()
    {
        
    }
}

