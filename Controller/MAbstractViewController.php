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

require_once __DIR__ . '/../Core/MSession.php';
require_once __DIR__ . '/../Core/MString.php';
require_once __DIR__ . '/../Core/Exception/MTemplateNotFoundException.php';
require_once __DIR__ . '/../View/GanonEngine.php';

use MToolkit\Core\MSession;
use MToolkit\Core\Exception\MTemplateNotFoundException;
use MToolkit\Core\MString;

abstract class MAbstractViewController extends MAbstractController
{
    const POST_SIGNALS = 'MToolkit\Controller\MAbstractViewController\PostSignals';

    /**
     * @var boolean
     */
    private $isVisible = true;

    /**
     * The path of the file containing the html of the controller.
     * @var string 
     */
    private $template = null;

    /**
     * It contains the controller rendered.
     * It's valorized after the call the method <i>render()<i>.
     * 
     * @var string|null 
     */
    private $output = "";
    
    /**
     * @var string CSS class
     */
    private $class=null;
    
    /**
     * @var string CSS style
     */
    private $style=null;
    
    /**
     * @var MAbstractViewController[] 
     */
    private $controls=array();
    
    /**
     * @var string An array of key => value
     */
    private $attributes=array();

    /**
     * @param string $template The path of the file containing the html of the controller.
     * @param MAbstractViewController $parent
     */
    public function __construct( $template = null, MAbstractViewController $parent = null )
    {
        parent::__construct( $parent );

        if ( file_exists( $template ) == false )
        {
            throw new MTemplateNotFoundException( $template );
        }

        $this->template = $template;
    }

    public function init()
    {
        $this->initControls();
    }

    public function initControls()
    {        
        ob_start();
        include $this->template;
        $output = ob_get_clean();
        
        /* @var $viewDoc HTML_Parser_HTML5 */ $viewDoc = str_get_dom( $output );
        $controlsHtml=$viewDoc('php|*');
                
        foreach ($controlsHtml as /* @var $controlHtml \HTML_Node */ $controlHtml)
        {
            $tagName=$controlHtml->getTag();
            
            $class=$controlHtml->getAttribute('namespace') . '\\' . $tagName;
            /* @var $classInstance MAbstractViewController */ $classInstance=new $class();
            
            if( ($classInstance instanceof MAbstractViewController)===false )
            {
                throw new Exception( 'The class ' . get_class( $classInstance ) . ' must be inherit from MAbstractViewController.' );
            }
            
            $classInstance->setParent($this);
            
            // Set control property and attributes
            foreach($controlHtml->attributes as $attributeKey => $attributeValue)
            {
                $controlHtml->deleteAttribute($attributeKey);
                
                if( $attributeKey!='namespace' )
                {
                    $method='set'.ucfirst($attributeKey);
                    
                    if( method_exists( $classInstance, $method ) )
                    {
                        $classInstance->$method($attributeValue);
                    }
                    else
                    {
                        $classInstance->setAttribute($attributeKey, $attributeValue);
                    }
                }
            }
            
            if( MString::isNullOrEmpty( $classInstance->getAttribute( 'id' ) ) )
            {
                throw new \Exception( 'The attribute id must be valorized for the ' . get_class( $classInstance ) . ' object.' );
            }
            
            $id=$classInstance->getAttribute( 'id' );
            $this->controls[$id]=$classInstance;
        }
    }
    
    /**
     * @return array
     */
    public function getAttributes(  )
    {
        return $this->attributes;
    }
    
    /**
     * @param string $name
     * @return string
     */
    public function getAttribute( $name )
    {
        if( array_key_exists( $name, $this->attributes ) )
        {
            return $this->attributes[$name];
        }
        
        return null;
    }
    
    /**
     * @param string $name
     * @param string $value
     */
    public function setAttribute( $name, $value )
    {
        $this->attributes[$name]=$value;
    }
    
    /**
     * @param string $name the id of the control
     * @return MAbstractViewController
     */
    public function getControl( $id )
    {
        if( array_key_exists( $id, $this->controls ) )
        {
            return $this->controls[$id];
        }
        
        return null;
    }
    
    /**
     * The method returns <i>$this->output</i>.
     * <i>$this->output</i> contains the controller rendered.
     * It's valorized after the call the method <i>render()<i>.
     * 
     * @return string|null
     */
    protected function getOutput()
    {
        return $this->output;
    }

    /**
     * The method sets <i>$this->output</i>.
     * <i>$this->output</i> contains the controller rendered.
     * 
     * @param string $output
     * @return \MToolkit\Controller\MAbstractViewController
     */
    protected function setOutput( $output )
    {
        $this->output = $output;
        return $this;
    }

    /**
     * The method returns the path of the html of the controler.
     * 
     * @return string|null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * The method sets the path of the html of the controler.
     * 
     * @param string $template
     * @return \MToolkit\Controller\AbstractController
     */
    protected function setTemplate( $template )
    {
        $this->template = $template;
        return $this;
    }

    /**
     * The method sets the visibility of the controller.
     * 
     * @return bool
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * The method returns the visibility of the controller.
     * 
     * @param bool $isVisible
     * @return \MToolkit\Controller\MAbstractViewController
     */
    public function setIsVisible( $isVisible )
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    /**
     * @return bool
     */
    public static function isPostBack()
    {
        return ( count( $_POST ) > 0 );
    }

    /**
     * If template is setted (the path of the html of controller) and if controller is visible,
     * it renders the template.
     */
    protected function render()
    {
        // It's better if the path of the template file is assigned.
        if ( $this->template == null )
        {
            trigger_error( "The path of the template file is null in " . get_class( $this ) . ' class.' . PHP_EOL, E_NOTICE );
            return;
        }

        if ( $this->isVisible === false )
        {
            return;
        }

        ob_start();

        include $this->template;

        $this->output .= ob_get_clean();
        
        $this->renderControls();
    }

    public function setClass( $class )
    {
        $this->class=$class;
        return $this;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function getStyle()
    {
        return $this->style;
    }

    public function setStyle( $style )
    {
        $this->style = $style;
        return $this;
    }
    
    protected function renderControls()
    {
        /* @var $viewDoc HTML_Parser_HTML5 */ $viewDoc = str_get_dom( $this->getOutput() );
        $controlsHtml=$viewDoc('php|*');
                
        foreach ($controlsHtml as /* @var $controlHtml \HTML_Node */ $controlHtml)
        {
            $tagName=$controlHtml->getTag();
            $class=$controlHtml->getAttribute('namespace') . '\\' . $tagName;
            $objectId=$controlHtml->getAttribute('id');
                        
            // Set the tag container of the control
            $controlHtml->setNamespace("");
            $controlHtml->setTag("div");
            $controlHtml->setAttribute('id', uniqid(str_replace('\\', '_', $class).'_'));
                        
            $classAttribute=$this->getControl( $objectId )->getAttribute( 'class' );
            if( MString::isNullOrEmpty( $classAttribute )===false )
            {
                $controlHtml->setAttribute('class', $classAttribute );
            }
                        
            // Show control
            $this->getControl( $objectId )->render();
            $controlHtml->setInnerText($this->getControl( $objectId )->getOutput());
        }
        
        $this->setOutput( (string) $viewDoc );
    }
    
    /**
     * The method calls the render methods (<i>preRender</i>,
     * <i>render</i> and <i>postRender</i>) and it prints to screen 
     * the html of the controller rendered if it is visible.
     */
    public function show()
    {
        if ( $this->isVisible === false )
        {
            return;
        }

//        echo get_class( $this ) . "<br />";

        $this->preRender();
        $this->render();
        $this->postRender();

        echo $this->output;

        $this->output = "";
    }

    /**
     * This function run the UI process of the web application.
     * 
     * - Call preRender method of the last MAbstractController.
     * - Call render method of the last MAbstractController.
     * - Call postRender method of the last MAbstractController.
     * - Clean <i>$_SESSION</i>.
     * 
     * @throws \Exception when hte application try to running a non MAbstractController object.
     */
    public static function run()
    {
        /* @var $classes string[] */ $classes = get_declared_classes();

        /* @var $entryPoint string */ $entryPoint = $classes[count( $classes ) - 1];

        /* @var $controller \MToolkit\Controller\MAbstractController */ $controller = new $entryPoint();

        if ( ( $controller instanceof \MToolkit\Controller\MAbstractController ) === false )
        {
            $message = sprintf( "Invalid object for entry point in class %s, it must be an instance of MAbstractController, %s is passed.", get_class( $this ), get_class( $controller ) );

            throw new \Exception( $message );
        }

        $controller->init();
        $controller->load();
        $controller->show();

        // Clean the $_SESSION from signals.
        $controller->disconnectSignals();
    }

}