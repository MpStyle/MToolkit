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

require_once __DIR__.'/../MRPCJsonResponse.php';
require_once __DIR__.'/../MRPCJsonRequest.php';
require_once __DIR__.'/../MRPCJsonError.php';
require_once __DIR__.'/../../../../Core/MObject.php';
require_once __DIR__.'/MRPCJsonServerException.php';

use MToolkit\Core\MObject;
use MToolkit\Network\RPC\Json\MRPCJsonRequest;
use MToolkit\Network\RPC\Json\MRPCJsonResponse;
use MToolkit\Network\RPC\Json\MRPCJsonError;
use MToolkit\Network\RPC\Json\MRPCJsonServerException;

/**
 * This class is the base class for the web service classes.
 * A tipical implementation of web service RPC in JSON is:
 * 
 * class TestWS extends MAbstractWebService
 * {
 *      public function __construct()
 *      {
 *          parent::__construct();
 *      }
 * 
 *      public function add( $params )
 *      {
 *          $a=$params['a'];
 *          $b=$params['b'];
 * 
 *          $response=new MRPCJsonResponse();
 * 
 *          // The result must be an array.
 *          $response->setResult( array( $a+$b ) );
 * 
 *          $this->setResponse( $response );
 *      }
 * }
 * 
 * TestWS::run();
 * 
 * An example of JSON request could be:
 * {"jsonrpc": "2.0", "method": "add", "params": { 'a': 2, 'b':3 }, "id": 1}
 */
class MAbstractWebService extends MObject
{
    /**
     * @var MRPCJsonResponse
     */
    private $response=null;
    
    /**
     * @var MRPCJsonRequest
     */
    private $request=null;
    
    public function __construct()
    {
        
    }
    
    /**
     * @return MRPCJsonResponse 
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @return MRPCJsonRequest 
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the response of the web service.
     * It must be valorizated by derived classes.
     * 
     * @param MRPCJsonResponse $response 
     */
    public function setResponse( MRPCJsonResponse $response)
    {
        $this->response = $response;
    }

    public function init()
    {}
    
    /**
     * Reads the request and run the web method.
     */
    public function execute()
    {
        try
        {
            // Parse the request
            $rawRequest=file_get_contents('php://input');
            /* @var $request Request */ $request=json_decode($rawRequest, false);

            // Is valid request?
            if( $request==false )
            {
                throw new MRPCJsonServerException(sprintf('Invalid body (%s).', $rawRequest));
            }
            
            // Does the request respect the 2.0 specification?
            if( $request->jsonrpc!='2.0' )
            {
                throw new MRPCJsonServerException(sprintf('The request does not respect the 2.0 specification.'));
            }
            
            // Set the request properties
            $this->request=new MRPCJsonRequest();
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
                throw new MRPCJsonServerException('No service.');
            }
        }
        catch(MRPCJsonServerException $ex)
        {            
            $error=new MRPCJsonError();
            $error->setCode( -1 );
            $error->setMessage( $ex->getMessage() );
            
            $this->response=new Response();
            $this->response->setError( $error );
        }
    }
    
    public static function run()
    {
        /* @var $classes string[] */ $classes = get_declared_classes();

        /* @var $entryPoint string */ $entryPoint = $classes[count($classes) - 1];

        /* @var $webService MAbstractWebService */ $webService=new $entryPoint();
        $webService->init();
        $webService->execute();
        
        echo json_encode( $this->getResponse()->toArray() );
    }
}
