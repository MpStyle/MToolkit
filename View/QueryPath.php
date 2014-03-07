<?php

require __DIR__ . '/QueryPath/Exception.php';
require __DIR__ . '/QueryPath/ParseException.php';
require __DIR__ . '/QueryPath/IOException.php';
require __DIR__ . '/QueryPath/CSS/ParseException.php';
require __DIR__ . '/QueryPath/CSS/NotImplementedException.php';
require __DIR__ . '/QueryPath/CSS/EventHandler.php';
require __DIR__ . '/QueryPath/CSS/SimpleSelector.php';
require __DIR__ . '/QueryPath/CSS/Selector.php';
require __DIR__ . '/QueryPath/CSS/Traverser.php';
require __DIR__ . '/QueryPath/CSS/DOMTraverser/PseudoClass.php';
require __DIR__ . '/QueryPath/CSS/DOMTraverser/Util.php';
require __DIR__ . '/QueryPath/CSS/DOMTraverser.php';
require __DIR__ . '/QueryPath/CSS/Token.php';
require __DIR__ . '/QueryPath/CSS/InputStream.php';
require __DIR__ . '/QueryPath/CSS/Scanner.php';
require __DIR__ . '/QueryPath/CSS/Parser.php';
require __DIR__ . '/QueryPath/CSS/QueryPathEventHandler.php';
require __DIR__ . '/QueryPath/Query.php';
require __DIR__ . '/QueryPath/Entities.php';
require __DIR__ . '/QueryPath/Extension.php';
require __DIR__ . '/QueryPath/ExtensionRegistry.php';
require __DIR__ . '/QueryPath/Options.php';
require __DIR__ . '/QueryPath/QueryPathIterator.php';
require __DIR__ . '/QueryPath/DOMQuery.php';

/**
 * @file
 *
 * QueryPath functions.
 *
 * This file holds the QueryPath functions, qp() and htmlqp().
 *
 * Usage:
 *
 * @code
 * <?php
 * require 'qp.php';
 *
 * qp($xml)->find('foo')->count();
 * ?>
 * @endcode
 */
/** @addtogroup querypath_core Core API
 * Core classes and functions for QueryPath.
 *
 * These are the classes, objects, and functions that developers who use QueryPath
 * are likely to use. The qp() and htmlqp() functions are the best place to start,
 * while most of the frequently used methods are part of the QueryPath object.
 */
/** @addtogroup querypath_util Utilities
 * Utility classes for QueryPath.
 *
 * These classes add important, but less-often used features to QueryPath. Some of
 * these are used transparently (QueryPathIterator). Others you can use directly in your
 * code (QueryPathEntities).
 */
/** @namespace QueryPath
 * The core classes that compose QueryPath.
 *
 * The QueryPath classes contain the brunt of the QueryPath code. If you are
 * interested in working with just the CSS engine, you may want to look at CssEventHandler,
 * which can be used without the rest of QueryPath. If you are interested in looking
 * carefully at QueryPath's implementation details, then the QueryPath class is where you
 * should begin. If you are interested in writing extensions, than you may want to look at
 * QueryPathExtension, and also at some of the simple extensions, such as QPXML.
 */

/**
 * Build a new Query Path.
 * This builds a new Query Path object. The new object can be used for
 * reading, search, and modifying a document.
 *
 * While it is permissible to directly create new instances of a QueryPath
 * implementation, it is not advised. Instead, you should use this function
 * as a factory.
 *
 * Example:
 * @code
 * <?php
 * qp(); // New empty QueryPath
 * qp('path/to/file.xml'); // From a file
 * qp('<html><head></head><body></body></html>'); // From HTML or XML
 * qp(QueryPath::XHTML_STUB); // From a basic HTML document.
 * qp(QueryPath::XHTML_STUB, 'title'); // Create one from a basic HTML doc and position it at the title element.
 *
 * // Most of the time, methods are chained directly off of this call.
 * qp(QueryPath::XHTML_STUB, 'body')->append('<h1>Title</h1>')->addClass('body-class');
 * ?>
 * @endcode
 *
 * This function is used internally by QueryPath. Anything that modifies the
 * behavior of this function may also modify the behavior of common QueryPath
 * methods.
 *
 * <b>Types of documents that QueryPath can support</b>
 *
 *  qp() can take any of these as its first argument:
 *
 *  - A string of XML or HTML (See {@link XHTML_STUB})
 *  - A path on the file system or a URL
 *  - A {@link DOMDocument} object
 *  - A {@link SimpleXMLElement} object.
 *  - A {@link DOMNode} object.
 *  - An array of {@link DOMNode} objects (generally {@link DOMElement} nodes).
 *  - Another {@link QueryPath} object.
 *
 * Keep in mind that most features of QueryPath operate on elements. Other
 * sorts of DOMNodes might not work with all features.
 *
 * <b>Supported Options</b>
 *  - context: A stream context object. This is used to pass context info
 *    to the underlying file IO subsystem.
 *  - encoding: A valid character encoding, such as 'utf-8' or 'ISO-8859-1'.
 *    The default is system-dependant, typically UTF-8. Note that this is
 *    only used when creating new documents, not when reading existing content.
 *    (See convert_to_encoding below.)
 *  - parser_flags: An OR-combined set of parser flags. The flags supported
 *    by the DOMDocument PHP class are all supported here.
 *  - omit_xml_declaration: Boolean. If this is TRUE, then certain output
 *    methods (like {@link QueryPath::xml()}) will omit the XML declaration
 *    from the beginning of a document.
 *  - format_output: Boolean. If this is set to TRUE, QueryPath will format
 *    the HTML or XML output to make it more readible. If this is set to
 *    FALSE, QueryPath will minimize whitespace to keep the document smaller
 *    but harder to read.
 *  - replace_entities: Boolean. If this is TRUE, then any of the insertion
 *    functions (before(), append(), etc.) will replace named entities with
 *    their decimal equivalent, and will replace un-escaped ampersands with
 *    a numeric entity equivalent.
 *  - ignore_parser_warnings: Boolean. If this is TRUE, then E_WARNING messages
 *    generated by the XML parser will not cause QueryPath to throw an exception.
 *    This is useful when parsing
 *    badly mangled HTML, or when failure to find files should not result in
 *    an exception. By default, this is FALSE -- that is, parsing warnings and
 *    IO warnings throw exceptions.
 *  - convert_to_encoding: Use the MB library to convert the document to the
 *    named encoding before parsing. This is useful for old HTML (set it to
 *    iso-8859-1 for best results). If this is not supplied, no character set
 *    conversion will be performed. See {@link mb_convert_encoding()}.
 *    (QueryPath 1.3 and later)
 *  - convert_from_encoding: If 'convert_to_encoding' is set, this option can be
 *    used to explicitly define what character set the source document is using.
 *    By default, QueryPath will allow the MB library to guess the encoding.
 *    (QueryPath 1.3 and later)
 *  - strip_low_ascii: If this is set to TRUE then markup will have all low ASCII
 *    characters (<32) stripped out before parsing. This is good in cases where
 *    icky HTML has (illegal) low characters in the document.
 *  - use_parser: If 'xml', Parse the document as XML. If 'html', parse the
 *    document as HTML. Note that the XML parser is very strict, while the
 *    HTML parser is more lenient, but does enforce some of the DTD/Schema.
 *    <i>By default, QueryPath autodetects the type.</i>
 *  - escape_xhtml_js_css_sections: XHTML needs script and css sections to be
 *    escaped. Yet older readers do not handle CDATA sections, and comments do not
 *    work properly (for numerous reasons). By default, QueryPath's *XHTML methods
 *    will wrap a script body with a CDATA declaration inside of C-style comments.
 *    If you want to change this, you can set this option with one of the
 *    JS_CSS_ESCAPE_* constants, or you can write your own.
 *  - QueryPath_class: (ADVANCED) Use this to set the actual classname that
 *    {@link qp()} loads as a QueryPath instance. It is assumed that the
 *    class is either {@link QueryPath} or a subclass thereof. See the test
 *    cases for an example.
 *
 * @ingroup querypath_core
 * @param mixed $document
 *  A document in one of the forms listed above.
 * @param string $string
 *  A CSS 3 selector.
 * @param array $options
 *  An associative array of options. Currently supported options are listed above.
 * @return QueryPath
 */
function qp($document = NULL, $string = NULL, $options = array())
{
    return QueryPath::with($document, $string, $options);
}

/**
 * A special-purpose version of {@link qp()} designed specifically for HTML.
 *
 * XHTML (if valid) can be easily parsed by {@link qp()} with no problems. However,
 * because of the way that libxml handles HTML, there are several common steps that
 * need to be taken to reliably parse non-XML HTML documents. This function is
 * a convenience tool for configuring QueryPath to parse HTML.
 *
 * The following options are automatically set unless overridden:
 *  - ignore_parser_warnings: TRUE
 *  - convert_to_encoding: ISO-8859-1 (the best for the HTML parser).
 *  - convert_from_encoding: auto (autodetect encoding)
 *  - use_parser: html
 *
 * Parser warning messages are also suppressed, so if the parser emits a warning,
 * the application will not be notified. This is equivalent to
 * calling @code@qp()@endcode.
 *
 * Warning: Character set conversions will only work if the Multi-Byte (mb) library
 * is installed and enabled. This is usually enabled, but not always.
 *
 * @ingroup querypath_core
 * @see qp()
 */
function htmlqp($document = NULL, $selector = NULL, $options = array())
{
    return QueryPath::withHTML($document, $selector, $options);
}

/** @file
 * The Query Path package provides tools for manipulating a structured document.
 * Typically, the sort of structured document is one using a Document Object Model
 * (DOM).
 * The two major DOMs are the XML DOM and the HTML DOM. Using Query Path, you can
 * build, parse, search, and modify DOM documents.
 *
 * To use QueryPath, only one file must be imported: qp.php. This file defines
 * the `qp()` function, and also registers an autoloader if necessary.
 *
 * Standard usage:
 * @code
 * <?php
 * require 'qp.php';
 *
 * $xml = '<?xml version="1.0"?><test><foo id="myID"/></test>';
 *
 * // Procedural call a la jQuery:
 * $qp = qp($xml, '#myID');
 * $qp->append('<new><elements/></new>')->writeHTML();
 *
 * // Object-oriented version with a factory:
 * $qp = QueryPath::with($xml)->find('#myID')
 * $qp->append('<new><elements/></new>')->writeHTML();
 * ?>
 * @endcode
 *
 * The above would print (formatted for readability):
 * @code
 * <?xml version="1.0"?>
 * <test>
 *  <foo id="myID">
 *    <new>
 *      <element/>
 *    </new>
 *  </foo>
 * </test>
 * @endcode
 *
 * ## Discovering the Library
 *
 * To gain familiarity with QueryPath, the following three API docs are
 * the best to start with:
 *
 * - qp(): This function constructs new queries, and is the starting point
 *  for manipulating a document. htmlqp() is an alias tuned for HTML
 *  documents (especially old HTML), and QueryPath::with(), QueryPath::withXML()
 *  and QueryPath::withHTML() all perform a similar role, but in a purely
 *  object oriented way.
 * - QueryPath: This is the top-level class for the library. It defines the
 *  main factories and some useful functions.
 * - QueryPath::Query: This defines all of the functions in QueryPath. When
 *  working with HTML and XML, the QueryPath::DOMQuery is the actual
 *  implementation that you work with.
 *
 * Included with the source code for QueryPath is a complete set of unit tests
 * as well as some example files. Those are good resources for learning about
 * how to apply QueryPath's tools. The full API documentation can be generated
 * from these files using Doxygen, or you can view it online at
 * http://api.querypath.org.
 *
 * If you are interested in building extensions for QueryPath, see the
 * QueryPath and QueryPath::Extension classes. There you will find information on adding
 * your own tools to QueryPath.
 *
 * QueryPath also comes with a full CSS 3 selector implementation (now
 * with partial support for the current draft of the CSS 4 selector spec). If
 * you are interested in reusing that in other code, you will want to start
 * with QueryPath::CSS::EventHandler.php, which is the event interface for the parser.
 *
 * All of the code in QueryPath is licensed under an MIT-style license
 * license. All of the code is Copyright, 2012 by Matt Butcher.
 *
 * @author M Butcher <matt @aleph-null.tv>
 * @license MIT
 * @see QueryPath
 * @see qp()
 * @see http://querypath.org The QueryPath home page.
 * @see http://api.querypath.org An online version of the API docs.
 * @see http://technosophos.com For how-tos and examples.
 * @copyright Copyright (c) 2009-2012, Matt Butcher.
 * @version -UNSTABLE% (3.x.x)
 *
 */

/**
 *
 */
class QueryPath
{

    /**
     * The version string for this version of QueryPath.
     *
     * Standard releases will be of the following form: <MAJOR>.<MINOR>[.<PATCH>][-STABILITY].
     *
     * Examples:
     * - 2.0
     * - 2.1.1
     * - 2.0-alpha1
     *
     * Developer releases will always be of the form dev-<DATE>.
     *
     * @since 2.0
     */
    const VERSION = '3.0.x';

    /**
     * Major version number.
     *
     * Examples:
     * - 3
     * - 4
     *
     * @since 3.0.1
     */
    const VERSION_MAJOR = 3;

    /**
     * This is a stub HTML 4.01 document.
     *
     * <b>Using {@link QueryPath::XHTML_STUB} is preferred.</b>
     *
     * This is primarily for generating legacy HTML content. Modern web applications
     * should use QueryPath::XHTML_STUB.
     *
     * Use this stub with the HTML familiy of methods (QueryPath::Query::html(),
     * QueryPath::Query::writeHTML(), QueryPath::Query::innerHTML()).
     */
    const HTML_STUB = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Untitled</title>
  </head>
  <body></body>
  </html>';

    /**
     * This is a stub XHTML document.
     *
     * Since XHTML is an XML format, you should use XML functions with this document
     * fragment. For example, you should use {@link xml()}, {@link innerXML()}, and
     * {@link writeXML()}.
     *
     * This can be passed into {@link qp()} to begin a new basic HTML document.
     *
     * Example:
     * @code
     * $qp = qp(QueryPath::XHTML_STUB); // Creates a new XHTML document
     * $qp->writeXML(); // Writes the document as well-formed XHTML.
     * @endcode
     * @since 2.0
     */
    const XHTML_STUB = '<?xml version="1.0"?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Untitled</title>
  </head>
  <body></body>
  </html>';

    public static function with($document = NULL, $selector = NULL, $options = array())
    {
        $qpClass = isset($options['QueryPath_class']) ? $options['QueryPath_class'] : '\QueryPath\DOMQuery';

        $qp = new $qpClass($document, $selector, $options);
        return $qp;
    }

    public static function withXML($source = NULL, $selector = NULL, $options = array())
    {
        $options += array(
            'use_parser' => 'xml',
        );
        return self::with($source, $selector, $options);
    }

    public static function withHTML($source = NULL, $selector = NULL, $options = array())
    {
        // Need a way to force an HTML parse instead of an XML parse when the
        // doctype is XHTML, since many XHTML documents are not valid XML
        // (because of coding errors, not by design).

        $options += array(
            'ignore_parser_warnings' => TRUE,
            'convert_to_encoding' => 'ISO-8859-1',
            'convert_from_encoding' => 'auto',
            //'replace_entities' => TRUE,
            'use_parser' => 'html',
                // This is stripping actually necessary low ASCII.
                //'strip_low_ascii' => TRUE,
        );
        return @self::with($source, $selector, $options);
    }

    /**
     * Enable one or more extensions.
     *
     * Extensions provide additional features to QueryPath. To enable and 
     * extension, you can use this method.
     *
     * In this example, we enable the QPTPL extension:
     * @code
     * <?php
     * QueryPath::enable('\QueryPath\QPTPL');
     * ?>
     * @endcode
     *
     * Note that the name is a fully qualified class name.
     *
     * We can enable more than one extension at a time like this:
     *
     * @code
     * <?php
     * $extensions = array('\QueryPath\QPXML', '\QueryPath\QPDB');
     * QueryPath::enable($extensions);
     * ?>
     * @endcode
     *
     * @attention If you are not using an autoloader, you will need to
     * manually `require` or `include` the files that contain the
     * extensions.
     *
     * @param mixed $extensionNames
     *   The name of an extension or an array of extension names.
     *   QueryPath assumes that these are extension class names,
     *   and attempts to register these as QueryPath extensions.
     */
    public static function enable($extensionNames)
    {

        if (is_array($extensionNames))
        {
            foreach ($extensionNames as $extension)
            {
                \QueryPath\ExtensionRegistry::extend($extension);
            }
        }
        else
        {
            \QueryPath\ExtensionRegistry::extend($extensionNames);
        }
    }

    /**
     * Get a list of all of the enabled extensions.
     *
     * This example dumps a list of extensions to standard output:
     * @code
     * <?php
     * $extensions = QueryPath::enabledExtensions();
     * print_r($extensions);
     * ?>
     * @endcode
     *
     * @retval array
     *   An array of extension names.
     *
     * @see QueryPath::ExtensionRegistry
     */
    public static function enabledExtensions()
    {
        return \QueryPath\ExtensionRegistry::extensionNames();
    }

    /**
     * A static function for transforming data into a Data URL.
     *
     * This can be used to create Data URLs for injection into CSS, JavaScript, or other
     * non-XML/HTML content. If you are working with QP objects, you may want to use
     * dataURL() instead.
     *
     * @param mixed $data
     *  The contents to inject as the data. The value can be any one of the following:
     *  - A URL: If this is given, then the subsystem will read the content from that URL. THIS
     *    MUST BE A FULL URL, not a relative path.
     *  - A string of data: If this is given, then the subsystem will encode the string.
     *  - A stream or file handle: If this is given, the stream's contents will be encoded
     *    and inserted as data.
     *  (Note that we make the assumption here that you would never want to set data to be
     *  a URL. If this is an incorrect assumption, file a bug.)
     * @param string $mime
     *  The MIME type of the document.
     * @param resource $context
     *  A valid context. Use this only if you need to pass a stream context. This is only necessary
     *  if $data is a URL. (See {@link stream_context_create()}).
     * @return
     *  An encoded data URL.
     */
    public static function encodeDataURL($data, $mime = 'application/octet-stream', $context = NULL)
    {
        if (is_resource($data))
        {
            $data = stream_get_contents($data);
        }
        elseif (filter_var($data, FILTER_VALIDATE_URL))
        {
            $data = file_get_contents($data, FALSE, $context);
        }

        $encoded = base64_encode($data);

        return 'data:' . $mime . ';base64,' . $encoded;
    }

}
