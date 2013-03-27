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
     * @var MList List of <i>MAbstractController</i>
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

    /**
     * Add child <i>$controller</i> to this controller.
     * The parent of <i>$controller</i> is <i>$this</i>.
     * 
     * @param \MToolkit\Controller\MAbstractController $controller
     */
    public function addController( MAbstractController $controller )
    {
        $controller->setParent($this);
        $this->controllers->append( $controller );
    }

    /**
     * Remove the child controller at position </i>$pos</i> if this controller.
     * The parent of <i>$controller</i> is <i>null</i>.
     * 
     * @param type $pos
     */
    public function removeController( $pos )
    {
        $this->controllers->at($pos)->setParent( null );
        $this->controllers->removeAt( $pos );
    }

    /**
     * Return the iterator of the children controllers.
     * @return \MToolkit\Core\MListIterator
     */
    public function getControllerIterator()
    {
        $iterator = new MListIterator( $this->controllers );
        return $iterator;
    }

    /**
     * This method pre-renderize its children controllers.
     * 
     * @return MAbstractController
     */
    public function preRender()
    {
        $controllersIt = new MListIterator( $this->controllers );

        foreach( $controllersIt as $key => /* @var $controller MAbstractController */ $controller )
        {
            $controller->preRender();
        }
        
        return $this;
    }

    /**
     * Render this controller.
     * The body of this method is empty in MAbstractController class.
     */
    public function render()
    {
        
    }

    /**
     * This method post-renderize its children controllers.
     * 
     * @return MAbstractController
     */
    public function postRender()
    {
        $controllersIt = new MListIterator( $this->controllers );

        foreach( $controllersIt as $key => /* @var $controller MAbstractController */ $controller )
        {
            $controller->postRender();
        }
        
        return $this;
    }
    
    /**
     * Print to screen the controller rendered in method <i>render()</i>
     */
    public abstract function show();
    
    public abstract static function run();

}