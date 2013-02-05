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

require_once dirname(__FILE__).'/MAbstractPageController.php';

use \MToolkit\Controller\MAbstractPageController;

abstract class MAbstractMasterPageController extends MAbstractPageController
{
    /**
     * @param string $template
     * @param MAbstractViewController $parent
     */
    public function __construct( $template = null, MAbstractPageController $parent=null )
    {
        parent::__construct( $template, $parent );
        
        if( $parent==null )
        {
            trigger_error('The parent of MasterPage is not set. You must set it for a correct execution of the render process.', E_USER_WARNING);
        }
    }
    
    public function pageRender()
    {
        $masterPage=parent::getParent()->getMasterPage();
        
        parent::getParent()->setMasterPage(null);
        
        parent::getParent()->render();
        
        parent::getParent()->setMasterPage($masterPage);
    }
}
