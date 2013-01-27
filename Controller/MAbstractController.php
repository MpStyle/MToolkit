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

require_once dirname( __FILE__ ) . '/RunController.php';

use \MToolkit\Core\MObject;
use \MToolkit\Core\MList;
use \MToolkit\Core\MListIterator;

abstract class MAbstractController extends MObject
{

    /**
     * @var string 
     */
    private $template = null;

    /**
     * @var MList<MAbstractController>
     */
    private $controllers = null;

    /**
     * @param string $template
     */
    public function __construct( $template = null )
    {
        $this->template = $template;
    }
    
    public function init()
    {
        $this->controllers = new MList();
    }

    /**
     * @return string|null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return \MToolkit\Controller\AbstractController
     */
    protected function setTemplate( $template )
    {
        $this->template = $template;
        return $this;
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
        include $this->template;
    }

    public function postRender()
    {
        $controllersIt = new MListIterator( $this->controllers );

        foreach( $controllersIt as $key => /* @var $controller MAbstractController */ $controller )
        {
            $controller->postRender();
        }
    }

}