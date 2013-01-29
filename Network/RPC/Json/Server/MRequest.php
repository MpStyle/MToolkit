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

/**
 * This class implement the standard RPC 2.0 using Json.
 * 
 * Example
 * {"jsonrpc": "2.0", "method": "subtract", "params": [42, 23], "id": 1} 
 */
class MRequest
{
    /**
     * @var string 
     */
    private $jsonrpc='2.0';
    
    /**
     * @var string 
     */
    private $method=null;
    
    /**
     * @var mixed 
     */
    private $params=null;
    
    /**
     * @var int 
     */
    private $id=null;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method 
     */
    public function setMethod($method)
    {
        $this->method = $method;
        
        return $this;
    }

    /**
     * @return object 
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param object $params 
     */
    public function setParams($params)
    {
        $this->params = $params;
        
        return $this;
    }

    /**
     * @return int 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id 
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }


}
