MToolkit
========

MToolkit is a simple PHP toolkit, it is compliant with the PSR-0 Standard:
- A fully-qualified namespace and class must have the following structure \\<Vendor Name>\\(\\<Namespace\>)*\\<Class Name>.
- Each namespace must have a top-level namespace ("Vendor Name"). (Missing)
- Each namespace can have as many sub-namespaces as it wishes.
- Each namespace separator is converted to a DIRECTORY_SEPARATOR when loading from the file system.
- Each underscore in the class name is converted to a DIRECTORY_SEPARATOR. The underscore has no special meaning in the namespace.
- The fully-qualified namespace and class is suffixed with .php when loading from the file system.
- Alphabetic characters in vendor names, namespaces, and class names may be of any combination of lower case and upper case.

It borns from a requirement: develop a website quickly and powerfully.

I know, someone can says "Use Zend Framwork, CakePHP!", but I could answer: "They are very good toolkits, but they aren't the toolkit that I want!" :P



The experiences with other toolkit in different platforms have led to create this toolkit.

MToolkit borns like a mash-up of two frameworks: .NET and Qt. o_O

Yes, the framework of the evil and the desktop framework for excellence.


Some good features
------------------
- Completely Object Oriented
- Autoload of classes (PSR-0 Standard)
- Autorun of pages and of RPC Json web services from controller classes
- Javascript frameworks compatibility (jQuery, Bootstrap, etc)
- Master page concept (http://msdn.microsoft.com/it-it/library/system.web.ui.masterpage.aspx)
- Separation between business logic and graphics


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

Entry page
-----------

An entry page is the page loaded at start time.
Now, we will see how create the controller of the entry page and his html code.

Controller (Index.php):

```
<?php

require_once __DIR__ . '/Settings.php';

use \MToolkit\Controller\MAbstractPageController;

class Index extends MAbstractPageController
{
    private $masterPage;

    public function __construct()
    {
        parent::__construct(__DIR__.'/Index.view');
    }

    public function helloWorld()
    {
        return "Hello World";
    }
} 

        
        
```

The html code will be write into the file *Index.view*:

```
<?php /* @var $this Index */ ?>
<html>
    <head>
        <title>Entry page</title>
    </head>
    <body>
        <b><?php echo $this->helloWorld(); ?></b>
    </body>
</html>
```
