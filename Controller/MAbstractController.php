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

/**
 * MAbstractController class provides a base methods
 * for the controller classes. <br />
 */
abstract class MAbstractController extends MObject
{
    /**
     * Constructs an abstract controller with the given <i>$parent</i>.
     * 
     * @param MObject $parent
     */
    public function __construct( MObject $parent=null )
    {
        parent::__construct( $parent );
    }
    
    /**
     * This method initialize the controller.
     */
    public function init()
    {
    }   

    public function load()
    {}
    
    /**
     * This method pre-renderize the controller.
     */
    protected function preRender()
    {
    }

    /**
     * Render the controller.
     */
    protected abstract function render();

    /**
     * This method post-renderize the controller.
     */
    protected function postRender()
    {
    }
    
    /**
     * Print to screen the controller rendered in method <i>MAbstractController::render()</i>
     */
    public abstract function show();
    
    /**
     * It is the entry point to load the controller.
     */
    public static function run()
    {}

}