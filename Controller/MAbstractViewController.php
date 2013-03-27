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

require_once dirname( __FILE__ ) . '/../Core/MSession.php';

use MToolkit\Core\MSession;

abstract class MAbstractViewController extends MAbstractController
{
    const POST_SIGNALS = 'MToolkit\Controller\MAbstractViewController\PostSignals';

    /**
     * @var boolean
     */
    private $isVisible = true;

    /**
     * @var string 
     */
    private $template = null;

    /**
     * It contains the controller rendered.
     * It's valorized after the call the method <i>render()<i>.
     * 
     * @var string|null 
     */
    private $output = null;

    /**
     * @param string $template
     * @param MAbstractViewController $parent
     */
    public function __construct( $template = null, MAbstractViewController $parent = null )
    {
        parent::__construct( $parent );

        $this->template = $template;
    }

    public function init()
    {
        $this->emitPostSignals();
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

    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function setIsVisible( $isVisible )
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public static function isPostBack()
    {
        return ( count( $_POST ) > 0 );
    }

    /**
     * If template is setted (the path of the html of controller) and if controller is visible,
     * it renders the template.
     */
    public function render()
    {
        if ($this->template != null)
        {
            $this->output = "";
            
            if ($this->isVisible == false)
            {
                ob_start();

                include $this->template;

                $this->output = ob_get_clean();
            }
        }
    }

    public function show()
    {
        echo $this->output;
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

        if (( $controller instanceof \MToolkit\Controller\MAbstractController ) === false)
        {
            $message = sprintf( "Invalid object, it must be an instance of MAbstractController, %s is passed.", get_class( $controller ) );

            throw new \Exception( $message );
        }

        // It's better if the path of the template file is assigned.
        if ($controller->getTemplate() == null)
        {
            trigger_error( "The path of the template file is null in " . get_class( $controller ), E_USER_ERROR );
        }

        $controller->init();
        $controller->preRender();
        $controller->render();
        $controller->postRender();
        $controller->show();

        // Clean the $_SESSION from signals.
        $controller->disconnectSignals();
    }

}
