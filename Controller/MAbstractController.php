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

require_once __DIR__ . '/../Core/MObject.php';
require_once __DIR__ . '/MHttpResponse.php';
require_once __DIR__ . '/../Core/MMap.php';
require_once __DIR__ . '/../Core/MDataType.php';

use \MToolkit\Core\MObject;
<<<<<<< Updated upstream
use MToolkit\Controller\MHttpResponse;
=======
use MToolkit\Core\MMap;
use MToolkit\Core\MDataType;
>>>>>>> Stashed changes

/**
 * MAbstractController class provides a base methods
 * for the controller classes. <br />
 */
abstract class MAbstractController extends MObject
{
    /**
     * @var MMap
     */
    private $controls;

    /**
     * @var MHttpResponse
     */
    private $httpResponse = null;

    /**
     * Constructs an abstract controller with the given <i>$parent</i>.
     * 
     * @param MObject $parent
     */
    public function __construct( MObject $parent = null )
    {
        parent::__construct( $parent );

        $this->httpResponse = new MHttpResponse();
        $this->controls = new MMap();
    }

    /**
     * @return MHttpResponse
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * @param string $id
     * @param \MToolkit\Controller\MAbstractController $control
     */
    protected function addControl( $id, MAbstractController $control )
    {
        MDataType::mustBeString( $id );

        $this->controls->insert( $id, $control );
    }

    /**
     * @param string $id
     * @return MAbstractController
     */
    protected function getControl( $id )
    {
        MDataType::mustBeString( $id );

        return $this->controls->getValue( $id );
    }

}
