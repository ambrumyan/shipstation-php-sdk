<?php
namespace Shipstation\Request;

/**
 * Lewis Lancaster 2016
 *
 * Class Manager
 *
 * @package Shipstation\Request
 */

use Shipstation\Exception\RequestException;

class Manager
{

    /**
     * @var string
     */

    protected $headers;

    /**
     * @var array
     */

    protected $body;

    /**
     * Manager constructor.
     *
     * @param null $headers
     *
     * @param null $body
     */

    public function __construct( $headers=null, $body=null)
    {

        if( $headers !== null || $body !== null )
        {

            $this->headers = $headers;

            $this->body = $body;
        }
    }

    /**
     * Sets the headers
     *
     * @param $headers
     */

    public function setHeaders( $headers )
    {

        $this->headers = $headers;
    }

    /**
     * Sets the body
     *
     * @param $body
     */

    public function setBody( $body )
    {

        $this->body = $body;
    }

    /**
     * gets the headers
     *
     * @return string
     */

    public function getHeaders()
    {

        return $this->headers;
    }

    /**
     * Gets the body
     *
     * @return array
     */

    public function getBody()
    {

        return $this->body;
    }

    /**
     * Preforms a post action
     *
     * @param $address
     *
     * @return string
     */

    public function post( $address )
    {

        $request = $this->formatRequest();

        if( isset( $request['http']['method'] ) === false )
        {

            $request['http']['method'] = 'POST';
        }

        return $this->getRequest( $address,  stream_context_create( $request ) );
    }

    /**
     * Preforms a get action
     *
     * @param $address
     *
     * @return string
     */

    public function get( $address )
    {

        if( empty( $this->body ) )
        {

            throw new RequestException();
        }

        $address = $this->getUrlForGetRequest( $address );

        if( $address == null )
        {

            throw new RequestException();
        }

        $request = $this->formatRequestForHeadersOnly();

        if( isset( $request['http']['method'] ) === false )
        {

            $request['http']['method'] = 'GET';
        }

        return $this->getRequest( $address,  stream_context_create( $request ) );
    }

    /**
     * Preforms a delete action
     *
     * @param $address
     *
     * @return string
     */

    public function delete( $address )
    {

        $request = $this->formatRequest();

        if( isset( $request['http']['method'] ) === false )
        {

            $request['http']['method'] = 'DELETE';
        }

        return $this->getRequest( $address,  stream_context_create( $request ) );
    }

    /**
     * Retursn true if we can preform this action
     *
     * @return bool
     */

    public function canPreformRequest()
    {

        if( empty( $this->body ) )
        {

            return false;
        }

        if( $this->headers == null )
        {

            return false;
        }

        return true;
    }

    /**
     * Gets the result of a request
     *
     * @param $address
     *
     * @param $context
     *
     * @return string
     */

    private function getRequest( $address, $context=null )
    {

        $result = @file_get_contents( $address, null, $context );

        $this->checkResponseCode( $http_response_header );

        if( empty( $result ) )
        {

            throw new RequestException( $address, $context );
        }

        return $result;
    }

    /**
     * Formats a request
     *
     * @return array
     */

    private function formatRequest()
    {

        $content = http_build_query( $this->headers );

        $info = array(
            'http' => [
                'header' => $this->headers,
                'content' => $content
            ]
        );

        return $info;
    }

    /**
     * Returns a contentless context
     *
     * @return array
     */

    private function formatRequestForHeadersOnly()
    {

        $info = array(
            'http' => [
                'header' => $this->headers
            ]
        );

        return $info;
    }

    /**
     * Gets the url for a get request
     *
     * @param $address
     *
     * @return string
     */

    private function getUrlForGetRequest( $address )
    {

        return $address . "?" . $this->formatURLParameters();
    }

    /**
     * Formats the body to instead be the form of URL Parameters
     *
     * @return string
     */

    private function formatURLParameters()
    {

        $parameters = "";

        foreach( $this->body as $key=>$value )
        {

            $parameters = $parameters . $key . "=" . $value . "&";
        }

        return rtrim( $parameters, "&");
    }

    /**
     * Sets our headers from an array
     *
     * @param $headers
     */

    public function setHeadersFromArray( $headers )
    {

        $result = "";

        foreach( $headers as $key=>$value )
        {

            $result = $result . $key . ": " . $value . "\r\n";
        }

        if( $result == "" )
        {

            throw new RequestException();
        }

        $this->headers = $result;
    }

    /**
     * Checks our response code
     *
     * @param $response
     */

    public function checkResponseCode( $response )
    {

        $code = explode(" ", $response[0] )[1];

        if( $code == null )
        {

            throw new RequestException();
        }

        $array = [
            '400' => 'Bad Request',
            '401' => 'Unauthorized',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '405' => 'Not Allowed',
            '429' => 'Too Many Requests'
        ];

        foreach( $array as $key=>$value )
        {

            if( $key == $code )
            {

                throw new RequestException( $value );
            }
        }
    }
}