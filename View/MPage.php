<?php
require_once 'MToolkit/View/MUserControl.php';

class MPage extends MUserControl
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public static function show( $istance )
    {
        $output="";
        $istance->render( $output );
        echo $output;
    }
}

