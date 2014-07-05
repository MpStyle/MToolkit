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

require_once __DIR__.'/MRPCJsonError.php';
require_once __DIR__.'/MRPCJson.php';
require_once __DIR__.'/../MRPCResponse.php';

use MToolkit\Network\RPC\Json\MRPCJsonError;
use MToolkit\Network\RPC\Json\MRPCJson;
use MToolkit\Network\RPC\Json\MRPCResponse;

/**
 * Examples:
 * <ul>
 * <li>{"jsonrpc": "2.0", "result": 19, "id": 1}</li>
 * <li>{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Procedure not found."}, "id": 10} </li>
 * </ul>
 */
class MRPCJsonResponse extends MRPCResponse 
{    
    /**
     * @return array
     */
    public function toArray()
    {        
        $array=array(
            'jsonrpc' => MRPCJson::VERSION
            , 'result' => $this->getResult()
            , 'id' => $this->getId()
        );
        
        if( $this->getError()!=null )
        {
            $array['error']=$this->getError()->toArray();
        }
        
        return $array;
    }
    
    /**
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param array $json
     */
    public static function fromArray(array $json)
    {
        $response=new MRPCJsonResponse();
        
        $response->setError( MRPCJsonError::fromArray($json["error"]) );
        $response->setId($json["id"]);
        $response->setResult($json["result"]);
    }

}
