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

require_once dirname(__FILE__).'/../Core/MObject.php';
require_once dirname(__FILE__).'/../Core/MList.php';
require_once dirname(__FILE__).'/../Core/MListIterator.php';

use \MToolkit\Core\MObject;
use \MToolkit\Core\MList;
use \MToolkit\Core\MListIterator;

abstract class MAbstractController extends MObject
{
    /**
     * @var MList<MAbstractController>
     */
    private $controllers = null;

    /**
     * @param MObject $parent
     */
    public function __construct( MObject $parent=null )
    {
        parent::__construct( $parent );
    }
    
    public function init()
    {
        $this->controllers = new MList();
    }   

    public function addController( MAbstractController $controller )
    {
        $this->controllers->append( $controller );
    }

    public function removeController( $pos )
    {
        $this->controllers->removeAt( $pos );
    }

    public function getControllerIterator()
    {
        $iterator = new MListIterator( $this->controllers );
        return $iterator;
    }

    /**
     * This method pre-renderize its children controllers.
     */
    public function preRender()
    {
        $controllersIt = new MListIterator( $this->controllers );

        foreach( $controllersIt as $key => /* @var $controller MAbstractController */ $controller )
        {
            $controller->preRender();
        }
    }

    public function render()
    {
        
    }

    /**
     * This method post-renderize its children controllers.
     */
    public function postRender()
    {
        $controllersIt = new MListIterator( $this->controllers );

        foreach( $controllersIt as $key => /* @var $controller MAbstractController */ $controller )
        {
            $controller->postRender();
        }
    }
    
    /**
     * Print to screen the controller rendered in method <i>render()</i>
     */
    public abstract function show();
    
    public abstract static function run();

}