<?php
namespace MToolkit\Network\RPC\Json\Server;

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

require_once dirname(__FILE__).'/MError.php';
require_once dirname(__FILE__).'/../../../../Core/Json/MJsonObject.php';

use MToolkit\Core\Json\MJsonObject;

/**
 * Examples:
 * <ul>
 * <li>{"jsonrpc": "2.0", "result": 19, "id": 1}</li>
 * <li>{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Procedure not found."}, "id": 10} </li>
 * </ul>
 */
class MResponse extends MJsonObject
{
    /**
     * @var string 
     */
    private $jsonrpc='2.0';
    
    /**
     * @var mixed 
     */
    private $result=null;
    
    /**
     * @var int
     */
    private $id=null;
    
    /**
     * @var MError
     */
    private $error=null;

    /**
     * @return JsonObject 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return \MToolkit\Network\RPC\Json\MResponse 
     */
    public function setResult( $result)
    {
        $this->result = $result;
        
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
        
        return $this;
    }

    
    public function toJson()
    {        
        $array=array(
            'jsonrpc' => $this->jsonrpc
            , 'result' => $this->result
            , 'id' => $this->id
        );
        
        if( $this->error!=null )
        {
            $array['error']=array(
                'code' => $this->error->getCode()
                , 'message' => $this->error->getMessage()
            );
        }
        
        return json_encode($array);
    }
}
