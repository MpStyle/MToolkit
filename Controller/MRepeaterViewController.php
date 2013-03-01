<?php
namespace MToolkit\Controller;

require_once dirname(__FILE__).'/MAbstractController.php';

use \MToolkit\Controller\MAbstractViewController;

class MRepeaterViewController extends MAbstractViewController
{
    /**
     * @var objects[]
     */
    private $objects=array();
    
    /**
     * @var int
     */
    private $currentPosition=-1;
    
    /**
     * @var object
     */
    private $currentObject=null;
    
    /**
     * @param string $view
     * @param object[] $object
     * @param MAbstractViewController $parent
     */
    public function __construct( $view, $objects, MAbstractViewController $parent=null )
    {
        parent::__construct( $view, $parent );
        
        $this->objects=$objects;
    }
    
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
     * @return int
     */
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

    /**
     * @return object
     */
    public function getCurrentObject()
    {
        return $this->currentObject;
    }
}

