<?php

namespace MToolkit;

require_once __DIR__ . '/Core/MCoreApplication.php';

use MToolkit\Core\MCoreApplication;

class MSettings
{
    public static function run()
    {
        MCoreApplication::setApplicationDirPath( __DIR__ . '/..' );
    }
}

MSettings::run();
