<?php

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

/**
 * This function tun the UI process of the web application.
 * 
 * - Call preRender method of the last MAbstractController.
 * - Call render method of the last MAbstractController.
 * - Call postRender method of the last MAbstractController.
 * - Clean <i>$_SESSION</i>.
 * 
 * @throws \Exception when hte application try to running a non MAbstractController object.
 */
function run()
{
    /* @var $classes string[] */ $classes = get_declared_classes();

    /* @var $entryPoint string */ $entryPoint = $classes[count( $classes ) - 1];

    /* @var $controller \MToolkit\Controller\MAbstractController */ $controller = new $entryPoint();

    if( ( $controller instanceof \MToolkit\Controller\MAbstractController ) === false )
    {
        $message = sprintf( "Invalid object, it must be an instance of MAbstractController, %s is passed.", get_class( $controller ) );

        throw new \Exception( $message );
    }

    // It's better if the path of the template file is assigned.
    if( $controller->getTemplate() == null )
    {
        trigger_error( "The path of the template file is null.", E_USER_WARNING );
    }

    $controller->init();
    $controller->preRender();
    $controller->render();
    $controller->postRender();

    // Clean the $_SESSION from signals.
    $controller->disconnectSignals();
}
