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

require_once __DIR__.'/MRPCJson.php';
require_once __DIR__.'/../MRPCRequest.php';

use MToolkit\Network\RPC\Json\MRPCJson;
use MToolkit\Network\RPC\Json\MRPCRequest;

/**
 * This class implement the standard RPC 2.0 using Json.
 * 
 * Example
 * {"jsonrpc": "2.0", "method": "subtract", "params": [42, 23], "id": 1} 
 */
class MRPCJsonRequest extends MRPCRequest 
{   
    public function toArray()
    {
        $array=array(
            'jsonrpc' => MRPCJson::VERSION
            , 'method' => $this->getMethod()
            , 'params' => $this->getParams()
            , 'id' => $this->getId()
        );
        
        return json_encode($array);
    }

    public static function fromArray(array $json)
    {
        $request=new MRPCJsonRequest();
        
        $request->setId($json["id"]);
        $request->setId($json["method"]);
        $request->setId($json["params"]);
        
        return $request;
    }
}
