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

require_once dirname(__FILE__).'/MResponse.php';
require_once dirname(__FILE__).'/MRequest.php';

class MAbstractWebService
{
    /**
     * @var Response
     */
    private $response=null;
    
    /**
     * @var Request
     */
    private $request=null;
    
    public function __construct()
    {
        try
        {
            // Parse the request
            $rawRequest=file_get_contents('php://input');
            /* @var $request Request */ $request=json_decode($rawRequest, false);

            // Is valid request?
            if( $request==false )
            {
                throw new \Exception(sprintf('Invalid body (%s).', $rawRequest));
            }
            
            // Does the request respect the 2.0 specification?
            if( $request->jsonrpc!='2.0' )
            {
                throw new \Exception(sprintf('The request does not respect the 2.0 specification.'));
            }
            
            // Set the request properties
            $this->request=new MRequest();
            $this->request
                    ->setMethod($request->method)
                    ->setParams($request->params)
                    ->setId($request->id);

            // Call the procedure/member
            $callResponse=call_user_func(
                    array($this, $this->request->getMethod())
                    , $this->request->getParams());
            
            // Does the call fail?
            if( $callResponse===false )
            {
                throw new \Exception('No service.');
            }
        }
        catch(Exception $ex)
        {            
            $error=new MError();
            $error->setCode( -1 );
            $error->setMessage( $ex->getMessage() );
            
            $this->response=new Response();
            $this->response->setError( $error );
        }
    }
    
    /**
     * @return MResponse 
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @return string
     */
    public function getJsonResponse()
    {
        return $this->response->toJson();
    }
    
    /**
     * @return MRequest 
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param MResponse $response 
     */
    public function setResponse( MResponse $response)
    {
        $this->response = $response;
    }


}
