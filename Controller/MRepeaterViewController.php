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

require_once dirname(__FILE__) . '/MAbstractController.php';
require_once dirname(__FILE__) . '/../Model/MAbstractDataModel.php';

use \MToolkit\Controller\MAbstractViewController;
use MToolkit\Model\MAbstractDataModel;

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
    private $currentPosition=-1;
    private $headerTemplate = null;
    private $itemTemplate = null;
    private $footerTemplate = null;

    /**
     * @var MAbstractDataModel
     */
    private $model=null;

    /**
     * @param \MToolkit\Model\MAbstractDataModel|null $model
     * @param \MToolkit\Controller\MAbstractViewController $parent
     */
    public function __construct($model, MAbstractViewController $parent = null)
    {
        parent::__construct($parent);
        $this->model = $model;
    }

    public function render()
    {
        $this->renderHeaderTemplate();
        
        for ($i = 0; $i < $this->model->rowCount(); $i++)
        {
            $this->currentPosition=$i;
            $this->renderItemTemplate();
        }

        $this->renderFooterTemplate();
    }

    public function renderHeaderTemplate()
    {
        if ($this->headerTemplate == null)
        {
            return;
        }

        $this->setTemplate($this->headerTemplate);
        parent::render();
    }

    public function renderItemTemplate()
    {
        if ($this->itemTemplate == null)
        {
            return;
        }

        $this->setTemplate($this->itemTemplate);
        parent::render();
    }

    public function renderFooterTemplate()
    {
        if ($this->footerTemplate == null)
        {
            return;
        }

        $this->setTemplate($this->footerTemplate);
        parent::render();
    }

    public function getHeaderTemplate()
    {
        return $this->headerTemplate;
    }

    public function setHeaderTemplate($headerTemplate)
    {
        $this->headerTemplate = $headerTemplate;
        return $this;
    }

    public function getItemTemplate()
    {
        return $this->itemTemplate;
    }

    public function setItemTemplate($itemTemplate)
    {
        $this->itemTemplate = $itemTemplate;
        return $this;
    }

    public function getFooterTemplate()
    {
        return $this->footerTemplate;
    }

    public function setFooterTemplate($footerTemplate)
    {
        $this->footerTemplate = $footerTemplate;
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(MAbstractDataModel $model)
    {
        $this->model = $model;
        return $this;
    }
    
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }



}

