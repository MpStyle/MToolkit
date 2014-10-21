<?php

require_once __DIR__ . '/../Core/MApplication.php';

use MToolkit\Core\MApplication;

class Settings
{
    const SHOW_PHP_ERRORS = true;

    public static function run()
    {
        MApplication::setApplicationDirPath( __DIR__ . '/../..' );
        date_default_timezone_set('Europe/Rome');

        // Print errore and notice
        if( self::SHOW_PHP_ERRORS )
        {
            ini_set( 'display_errors', '1' );
            error_reporting( E_ALL & ~E_STRICT );
        }
        else
        {
            ini_set( 'display_errors', '0' );
            error_reporting( ~E_ALL );
        }
    }

}

Settings::run();
