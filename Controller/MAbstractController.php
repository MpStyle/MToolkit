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

require_once __DIR__.'/../Core/MObject.php';

use \MToolkit\Core\MObject;

abstract class MAbstractController extends MObject
{
    /**
     * @param MObject $parent
     */
    public function __construct( MObject $parent=null )
    {
        parent::__construct( $parent );
    }
    
    public function init()
    {
    }   

    /**
     * This method pre-renderize its children controllers.
     */
    protected function preRender()
    {
    }

    /**
     * Render this controller.
     */
    protected abstract function render();

    /**
     * This method post-renderize its children controllers.
     */
    protected function postRender()
    {
    }
    
    /**
     * Print to screen the controller rendered in method <i>render()</i>
     */
    public abstract function show();
    
    public abstract static function run();

}