<?php
namespace MToolkit\DebugConsole;

/* @var $this Index */
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div id="Content">
    <h1>
        <img src="Images/SmallLogo.png" alt="MToolkit logo" class="img-responsive" />
    </h1>
    
    <p>MToolkit is a simple PHP toolkit, it is compliant with the <strong>PSR-0 Standard</strong>:</p>
    
    <ul>
        <li>A fully-qualified namespace and class must have the following structure \&lt;<em>Vendor Name</em>&gt;\(&lt;<em>Namespace</em>&gt;)*\&lt;<em>Class Name</em>&gt;.</li>
        <li>Each namespace must have a top-level namespace (&quot;<em>Vendor Name</em>&quot;). (Missing)</li>
        <li>Each namespace can have as many sub-namespaces as it wishes.</li>
        <li>Each namespace separator is converted to a <em>DIRECTORY_SEPARATOR</em> when loading from the file system.</li>
        <li>Each underscore in the class name is converted to a <em>DIRECTORY_SEPARATOR</em>. The underscore has no special meaning in the namespace.</li>
        <li>The fully-qualified namespace and class is suffixed with .php when loading from the file system.</li>
        <li>Alphabetic characters in vendor names, namespaces, and class names may be of any combination of lower case and upper case.</li>
    </ul>

    <p>It borns from a requirement: develop a website quickly and powerfully.</p>

    <p>I know, someone can says "Use <a href="http://framework.zend.com/">Zend Framwork</a>, <a href="http://cakephp.org/">CakePHP</a>!", but I could answer: "They are very good toolkits, but they aren't the toolkit that I want!" :P</p>

    <p>The development model of MToolkit is rolling release. I search some people (developer or not) to increase and modify this strategy: my goal is to manage the versioning of this framework.</p>

    <p>The experiences with other toolkit in different platforms have led to create this toolkit.</p>

    <p>MToolkit borns like a mash-up of two frameworks: <a href="http://www.microsoft.com/net">.NET</a> and <a href="http://qt-project.org/">Qt</a>. o_O</p>

    <p>Yes, the framework of the evil and the desktop framework for excellence.</p>

    
    <h2>Some good features</h2>
    
    <ul>
        <li>Completely Object Oriented</li>
        <li>Autoload of classes (PSR-0 Standard)</li>
        <li>Autorun of pages and of RPC Json web services from controller classes</li>
        <li>Javascript frameworks compatibility (<a href="http://jquery.com/">jQuery</a>, <a href="http://getbootstrap.com/">Bootstrap</a>, etc)</li>
        <li>Master page concept (<a href="http://msdn.microsoft.com/it-it/library/system.web.ui.masterpage.aspx">as in .NET</a>)</li>
        <li>Separation between business logic and graphics</li>
        <li>Fluent setters</li>
    </ul>
    

    <h2>MToolkit components</h2>

    <p>Like <a href="http://qt-project.org/">Qt</a>, MToolkit has a lot of components, one for every type of usage. Here the list:</p>
    <ul>
        <li>Core</li>
        <li>Network</li>
        <li>Model/Sql</li>
        <li>Controller</li>
        <li>View</li>
    </ul>
</div>