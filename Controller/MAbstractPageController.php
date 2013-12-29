<?php
namespace MToolkit\Controller;

/*
 * This file is part of MToolkit.
 *
 * MToolkit is free software: you can redistribute it and/or modify
 * it under the terms of the LGNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MToolkit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * LGNU Lesser General Public License for more details.
 *
 * You should have received a copy of the LGNU Lesser General Public License
 * along with MToolkit.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

require_once __DIR__ . '/../Core/MString.php';
require_once __DIR__ . '/../View/qp.php';
require_once __DIR__ . '/MAbstractViewController.php';

use MToolkit\Core\MString;
use MToolkit\Controller\MAbstractMasterPageController;
use MToolkit\Core\Exception\MElementIdNotFoundException;
use MToolkit\Controller\MAbstractViewController;

abstract class MAbstractPageController extends MAbstractViewController
{
    const JAVASCRIPT_TEMPLATE = '<script type="text/javascript" src="%s"></script>';
    const CSS_TEMPLATE = '<link rel="%s" type="text/css" href="%s" media="%s" />';
    const MASTER_PAGE_PLACEHOLDER_ID = 'MasterPagePlaceholderId';
    const PAGE_CONTENT_ID = 'PageContentId';

    private $css = array( );
    private $javascript = array( );

    /**
     * @var MAbstractMasterPageController 
     */
    private $masterPage = null;
    private $masterPageParts = array( );

    /**
     * @var string|null 
     */
    private $pageTitle = null;
    
    

    /**
     * @param string $template
     * @param MAbstractViewController $parent
     */
    public function __construct( $template = null, MAbstractViewController $parent = null )
    {
        parent::__construct( $template, $parent );
    }

    public function addCss( $href, $media = CssMedia::ALL, $rel = CssRel::STYLESHEET )
    {
        if( MString::isNullOrEmpty( $href )===false )
        {
            $this->css[] = array(
                "href" => $href
                , "rel" => $rel
                , "media" => $media );
        }
    }

    public function addJavascript( $src )
    {
        if( MString::isNullOrEmpty( $src )===false )
        {
            $this->javascript[] = array( "src" => $src );
        }
    }

    /**
     * Render the link tag for CSS at the end of head tag.
     */
    public function renderCss()
    {
        $html = "";

        foreach( $this->css as $item )
        {
            $html.=sprintf( MAbstractPageController::CSS_TEMPLATE, $item["rel"], $item["href"], $item["media"] ) . "\n";
        }
                
        ob_start();
        qp($this->getOutput(), "head")
                ->append($html)
                ->writeHTML();
        $output = ob_get_clean();

        $this->setOutput( $output );
    }

    /**
     * Render the script tag for Javascript at the end of head tag.
     */
    public function renderJavascript()
    {
        $html = "";
        
        foreach( $this->javascript as $item )
        {
            $html.=sprintf( MAbstractPageController::JAVASCRIPT_TEMPLATE, $item["src"] ) . "\n";
        }

        ob_start();
        qp($this->getOutput(), "head")
                ->append($html)
                ->writeHTML();
        $output = ob_get_clean();

        $this->setOutput( $output );
    }

    public function getMasterPage()
    {
        return $this->masterPage;
    }

    public function setMasterPage( $masterPage )
    {
        $this->masterPage = $masterPage;
        return $this;
    }

    /**
     * Set what part of the page (<i>$pageContentId</i> is the id of the html element)
     * will be rendered in <i>$masterPagePlaceholderId</i> (is the id of the html
     * of master page).
     * 
     * @param string $masterPagePlaceholderId
     * @param string $pageContentId
     */
    public function addMasterPagePart( $masterPagePlaceholderId, $pageContentId )
    {
        $this->masterPageParts[] = array(
            MAbstractPageController::MASTER_PAGE_PLACEHOLDER_ID => $masterPagePlaceholderId
            , MAbstractPageController::PAGE_CONTENT_ID => $pageContentId
        );
    }

    protected function render()
    {
        // If the master page is not set, render the page.
        if( $this->masterPage==null )
        {
            parent::render();
            return;
        }

        // renders the master page
        ob_start();
        $this->masterPage->init();
        $this->masterPage->show();
        $masterPageRendered = ob_get_clean();
        /* @var $masterPageDoc HTML_Parser_HTML5 */ //$masterPageDoc = str_get_dom( $masterPageRendered );

        // renders the current page
        parent::render();
        $pageRendered = $this->getOutput();
        /* @var $pageDoc HTML_Parser_HTML5 */ //$pageDoc = str_get_dom( $pageRendered );

        // assemblies the master page and current page
        foreach( $this->masterPageParts as $masterPagePart )
        {
            $masterPagePlaceholderId = '#' . $masterPagePart[MAbstractPageController::MASTER_PAGE_PLACEHOLDER_ID];
            $pageContentId = '#' . $masterPagePart[MAbstractPageController::PAGE_CONTENT_ID];
            
            ob_start();
            qp($masterPageRendered, $masterPagePlaceholderId)
                    ->append(qp($pageRendered, $pageContentId)->innerHtml())
                    ->writeHTML();
            $masterPageRendered = ob_get_clean();
        }
        
        // set the output of page with the assemblies
        $this->setOutput( $masterPageRendered );
        
        $this->renderTitle();
        $this->renderCss();
        $this->renderJavascript();
    }
    
    public function renderTitle()
    {
        // Render page title
        if( $this->pageTitle!=null )
        {
            ob_start();
            qp($this->getOutput(), "title")
                    ->append($this->pageTitle)
                    ->writeHTML();
            $output = ob_get_clean();
            
            $this->setOutput( $output );
        }
    }

    public function postRender()
    {
        parent::postRender();
    }

    /**
     * This function run the UI process of the web application.
     * 
     * - Call preRender method of the last MAbstractController.
     * - Call render method of the last MAbstractController.
     * - Call postRender method of the last MAbstractController.
     * - Clean <i>$_SESSION</i>.
     * 
     * @throws \Exception when hte application try to running a non MAbstractController object.
     */
    public static function run()
    {
        /* @var $classes string[] */ $classes = get_declared_classes();

        /* @var $entryPoint string */ $entryPoint = $classes[count( $classes )-1];

        /* @var $controller \MToolkit\Controller\MAbstractController */ $controller = new $entryPoint();

        if( ( $controller instanceof \MToolkit\Controller\MAbstractPageController )===false )
        {
            $message = sprintf( "Invalid object for entry point in class %s, it must be an instance of MAbstractController, %s is passed.", get_class( $this ), get_class( $controller ) );

            throw new \Exception( $message );
        }

        $controller->show();

        // Clean the $_SESSION from signals.
        $controller->disconnectSignals();
    }

    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    public function setPageTitle( $pageTitle )
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

}

register_shutdown_function( array( 'MToolkit\Controller\MAbstractPageController', 'run' ) );

final class CssRel
{
    const STYLESHEET = "stylesheet";
    const ALTERNATE_STYLESHEET = "alternate stylesheet";

}

final class CssMedia
{
    const ALL = "all";
    const BRAILLE = "braille";
    const EMBOSSED = "embossed";
    const HANDHELD = "handheld";
    const PRINTER = "print";
    const PROJECTION = "projection";
    const SCREEN = "screen";
    const SPEECH = "speech";
    const TTY = "tty";
    const TV = "tv";

}