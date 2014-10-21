<?php
namespace MToolkit\DebugConsole;

/* @var $this QuickStart */
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div id="Content">

    <h1>Let's start</h1>

    <p>Create a folder for your project.</p>

    <p>Download the latest version of MToolkit in the project folder.</p>

    <p>On the <em>root</em> of your project create a new file (<em>Settings.php</em>) with this content:</p>

    <pre>
&lt;?php
require_once __DIR__.'/MToolkit/Core/MApplication.php';

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
    </pre>

    <p>This file sets the root of your project and now you no longer have to <em>use_require</em>, <em>require_once</em>, <em>include</em>, <em>include_once</em> directives.</p>

    <p>This file must be include in every entry page of your project.</p>

    <h2>Entry page</h2>

    <p>An entry page is the page loaded at start time. Now, we will see how create the controller of the entry page and his html code.</p>

    <h3>Controller (Index.php):</h3>

    <pre>
&lt;?php

require_once __DIR__ . '/Settings.php';

use \MToolkit\Controller\MAbstractPageController;

class Index extends MAbstractPageController
{
    public function __construct()
    {
        parent::__construct(__DIR__.'/Index.view');
    }

    public function helloWorld()
    {
        return "Hello World";
    }
}
    </pre>

    <p>And the view file. Every view file must contains the meta tag, with the correct <em>content-type</em>:</p>

    <pre>&lt;meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8"&gt;</pre>

    <h3>Index.view:</h3>

    <pre>
&lt;?php 
/* @var $this Index */
?&gt;
&lt;html&gt;
    &lt;head&gt;
        &lt;title&gt;Entry page&lt;/title&gt;
        &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8"&gt;
    &lt;/head&gt;
    &lt;body&gt;
        &lt;b&gt;
            &lt;?php echo $this->helloWorld(); ?&gt;
        &lt;/b&gt;
    &lt;/body&gt;
&lt;/html&gt;
    </pre>
</div>