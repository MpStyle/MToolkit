MToolkit
========

MToolkit is a simple PHP toolkit.

It borns from a requirement: develop a website quickly and powerfully.

I know, someone can says "Use Zend Framwork, CakePHP!", but I could answer: "They are very good toolkits, but they aren't the toolkit that I want!" :P



The experiences with other toolkit in different platforms have led to create this toolkit.

MToolkit borns like a mash-up of two frameworks: .NET and Qt. o_O

Yes, the framework of the evil and the desktop framework for excellence.


Let's start
-----------

Create a folder for your project.

Download the latest version of MToolkit in the project folder.

On the root of your project create a new file (*Settings.php*) with this content:

```

<?php
require_once __DIR__.'/MToolkit/Core/MCore.php';

use MToolkit\Core\MApplication;

class Settings
{
    public static function run()
    {
        // Set the root path of the project
        MApplication::setApplicationDirPath(__DIR__);
    }
}

Settings::run();

```

This file sets the root of your project and now you no longer have to use *require*, *require_once*, *include*, *include_once* directives. 

**This file must be include in every entry page of your project.**
