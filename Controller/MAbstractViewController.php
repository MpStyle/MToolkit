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

abstract class MAbstractViewController extends MAbstractController
{
    /**
     * @var boolean
     */
    private $isVisible=true;
    
    /**
     * @var MAbstractController 
     */
    private $parent=null;
    
    public function __construct($template=null)
    {
        parent::__construct($template);
    }
    
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function setIsVisible( $isVisible )
    {
        $this->isVisible = $isVisible;
        return $this;
    }
    
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent( MAbstractController $parent )
    {
        $this->parent = $parent;
        return $this;
    }
    
    public function isPostBack()
    {
        return ( count($_POST)>0 );
    }
}
