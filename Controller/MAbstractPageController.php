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

require_once dirname(__FILE__).'/../Core/MString.php';

use MToolkit\Core\MString;

abstract class MAbstractPageController extends MAbstractViewController
{
    const JAVASCRIPT_TEMPLATE='<script type="text/javascript" src="%s"></script>';
    const CSS_TEMPLATE = '<link rel="%s" type="text/css" href="%s" media="%s">';

    private $css = array( );
    private $javascript = array( );
    private $masterPage=null;
    
    /**
     * @param string $template
     * @param MAbstractViewController $parent
     */
    public function __construct( $template = null, MAbstractViewController $parent=null )
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

    public function renderCss()
    {
        $html = "";

        foreach( $this->css as $item )
        {
            $html.=sprintf( MAbstractPageController::CSS_TEMPLATE, $item["rel"], $item["href"], $item["media"] );
        }
        
        echo $html;
    }

    public function renderJavascript()
    {
        $html = "";

        foreach( $this->javascript as $item )
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
    
    public function render()
    {
        if( $this->masterPage!=null )
        {
            $this->masterPage->render();
            return;
        }
        
        parent::render();
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