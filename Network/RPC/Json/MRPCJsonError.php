<?php
namespace MToolkit\Network\RPC\Json;

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

require_once __DIR__.'/../../../Core/Json/MJsonObject.php';
require_once __DIR__.'/../MRPCError.php';

use MToolkit\Core\Json\MJsonObject;
use MToolkit\Network\RPC\MRPCError;

class MRPCJsonError extends MRPCError implements MJsonObject
{
    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            "code" => $this->getCode()
            , "message" => $this->getMessage()
        );
    }

    /**
     * @param array $json
     * @return \MToolkit\Network\RPC\Json\MRPCJsonError
     */
    public static function fromArray(array $json)
    {
        $error=new MRPCJsonError();
        
        $error->setCode($json["error"]);
        $error->setMessage($json["message"]);
        
        return $error;
    }
}