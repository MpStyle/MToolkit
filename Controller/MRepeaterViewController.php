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

require_once dirname(__FILE__).'/MAbstractController.php';

use \MToolkit\Controller\MAbstractViewController;

/**
 * The class <i>MRepeaterViewController</i> make possible to
 * render a view with content repeated.
 * 
 * <b>Customer.php</b>
 * 
 * <code>
 *  class Customer
 *  {
 *      private $name;
 * 
 *      [..]
 * 
 *      public function getName()
 *      {
 *          return $this->name;
 *      }
 *  }
 * </code>
 * 
 * <b>RepeaterTest.view.php</b>
 * 
 * <code>
 *  <div id="element">
 *      <?php echo $this->getCurrentObject()->getName(); ?>
 *  </div>
 * </code>
 * 
 * <b>RepeaterTest.php</b>
 * 
 * <code>
 *  class RepeaterTest extends MRepeaterViewController
 *  {
 *      public function __construct()
 *      {
 *          $customer=new Customer();
 *          $customer->setName( 'John' );
 * 
 *          $objects=array();
 *          $objects[]=$customer;
 * 
 *          parent::__construct('RepeaterTest.view.php', $objects, null);
 *      }
 *  }
 * </code>
 * 
 * <b>Index.view.php<b/>
 * 
 * <code>
 *  <html>
 *      <body>
 *          <?php $this->repeater->render(); ?>
 *      </body>
 *  </html>
 * </code>
 * 
 * <b>Index.php<b/>
 * 
 * <code>
 *  class Index extends MAbstractPageController
 *  {
 *      public $repeater;
 * 
 *      public function __construct()
 *      {
 *          $this->repeater=new RepeaterTest();
 *      }
 *  }
 * </code>
 */
class MRepeaterViewController extends MAbstractViewController
{
    /**
     * The array where are stored the elements.
     * @var objects[]
     */
    private $objects=array();
    
    /**
     * Stored the current position during the iteration.
     * 
     * @var int
     */
    private $currentPosition=-1;
    
    /**
     * Stored the current element during the iteration.
     * 
     * @var object
     */
    private $currentObject=null;
    
    /**
     * @param string $view The path of the file containing the HTML.
     * @param object[] $object Elements to render in the repeater.
     * @param MAbstractViewController $parent
     */
    public function __construct( $view, $objects, MAbstractViewController $parent=null )
    {
        parent::__construct( $view, $parent );
        
        $this->objects=$objects;
    }
    
    /**
     * Render the view.
     */
    public function render()
    {
        foreach( $this->objects as $pos => $object )
        {
            $this->currentPosition=$pos;
            $this->currentObject=$object;
            
            $this->renderView();
        }
    }
    
    public function renderView()
    {
        parent::render();
    }
    
    public function getItem( $pos )
    {
        return $this->objects[$pos];
    }
    
    public function getView()
    {
        return parent::getTemplate();
    }
    
    public function setView( $view )
    {
        parent::setTemplate($view);
    }
    
    /**
     * Return current position.
     * 
     * @return int
     */
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

    /**
     * Return current element.
     * 
     * @return object
     */
    public function getCurrentObject()
    {
        return $this->currentObject;
    }
}

