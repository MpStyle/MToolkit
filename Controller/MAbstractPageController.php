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

require_once dirname( __FILE__ ) . '/../Core/MString.php';
//require_once dirname( __FILE__ ) . '/MAbstractMasterPageController.php';
require_once dirname( __FILE__ ) . '/../View/phpQuery.php';

use MToolkit\Core\MString;
use MToolkit\Controller\MAbstractMasterPageController;
use \phpQuery;

abstract class MAbstractPageController extends MAbstractViewController
{
    const JAVASCRIPT_TEMPLATE = '<script type="text/javascript" src="%s"></script>';
    const CSS_TEMPLATE = '<link rel="%s" type="text/css" href="%s" media="%s">';
    const MASTER_PAGE_PLACEHOLDER_ID = 'MasterPagePlaceholderId';
    const PAGE_CONTENT_ID = 'PageContentId';

    private $css = array();
    private $javascript = array();

    /**
     * @var MAbstractMasterPageController 
     */
    private $masterPage = null;
    private $masterPageParts = array();

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
        if (MString::isNullOrEmpty( $href ) === false)
        {
            $this->css[] = array(
                "href" => $href
                , "rel" => $rel
                , "media" => $media);
        }
    }

    public function addJavascript( $src )
    {
        if (MString::isNullOrEmpty( $src ) === false)
        {
            $this->javascript[] = array("src" => $src);
        }
    }

    public function renderCss()
    {
        $html = "";

        foreach ( $this->css as $item )
        {
            $html.=sprintf( MAbstractPageController::CSS_TEMPLATE, $item["rel"], $item["href"], $item["media"] );
        }

        echo $html;
    }

    public function renderJavascript()
    {
        $html = "";

        foreach ( $this->javascript as $item )
        {
            $html.=sprintf( MAbstractPageController::JAVASCRIPT_TEMPLATE, $item["src"] );
        }

        echo $html;
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
        if ($this->masterPage == null)
        {
            parent::render();
            return;
        }

        // renders the master page
        ob_start();
        $this->masterPage->show();
        $masterPageRendered = ob_get_clean();
        /* @var $masterPageDoc phpQuery */ $masterPageDoc = phpQuery::newDocumentHTML( $masterPageRendered );
        
        // renders the current page
        parent::render();
        $pageRendered = $this->getOutput();
        /* @var $pageDoc phpQuery */ $pageDoc = phpQuery::newDocumentHTML( $pageRendered );
        
        // assemblies the master page and current page
        foreach ( $this->masterPageParts as $masterPagePart )
        {
            $masterPagePlaceholderId = '#' . $masterPagePart[MAbstractPageController::MASTER_PAGE_PLACEHOLDER_ID];
            $pageContentId = '#' . $masterPagePart[MAbstractPageController::PAGE_CONTENT_ID];
            
            $masterPageDoc[ $masterPagePlaceholderId]= $pageDoc[ $pageContentId];
        }
        
        // set the output of page with the assemblies
        $this->setOutput( (string) $masterPageDoc->html() );
    }

}

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