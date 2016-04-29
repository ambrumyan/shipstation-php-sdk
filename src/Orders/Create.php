<?php
namespace Shipstation\Orders;

/**
 * Lewis Lancaster 2016
 *
 * Class Create
 *
 * @package Shipstation\Orders
 */

use Shipstation\Authentication\Structures\Authenticator;
use Shipstation\Exception\OrderException;
use Shipstation\Authentication\Manager;
use Shipstation\Request\Manager as Request;

class Create
{

    /**
     * @var Manager
     */

    protected $authenticator;

    /**
     * @var array
     */

    protected $parameters;

    /**
     * Holds the address of this call
     *
     * @var string
     */

    protected $address = "https://ssapi.shipstation.com/orders/createorder";

    /**
     * Create constructor.
     *
     * @param Authenticator $authenticator
     */

    public function __construct( Authenticator $authenticator )
    {

        if( $authenticator instanceof Authenticator == false )
        {

            throw new OrderException();
        }

        $this->authenticator = new Manager( $authenticator );
    }

    /**
     * Sets the parameters
     *
     * @param $array
     */

    public function setParameters( $array )
    {

        $this->parameters = $array;
    }

    /**
     * Gets the parameters
     *
     * @return mixed
     */

    public function getParameters()
    {

        return $this->parameters;
    }

    /**
     * Gets our shipping address
     *
     * @return mixed
     */

    public function getShippingAddress()
    {

        if( isset( $this->parameters['shipTo'] ) == false )
        {

            throw new OrderException();
        }

        return $this->parameters['shipTo'];
    }

    /**
     * Sets our shipping address
     *
     * @param $array
     */

    public function setShippingAddress( $array )
    {

        if( empty( $this->parameters ) )
        {

            $this->parameters = array();
        }

        $this->parameters['shipTo'] = $array;
    }

    /**
     * Gets our billing address we have set
     *
     * @return mixed
     */

    public function getBillingAddress()
    {

        if( isset( $this->parameters['billTo'] ) == false )
        {

            throw new OrderException();
        }

        return $this->parameters['billTo'];
    }

    /**
     * Sets our billing address
     *
     * @param $array
     */

    public function setBillingAddress( $array )
    {

        if( empty( $this->parameters ) )
        {

            $this->parameters = array();
        }

        $this->parameters['billTo'] = $array;
    }

    /**
     * Gets our items
     *
     * @return mixed
     */

    public function getItems()
    {

        if( isset( $this->parameters['items'] ) == false )
        {

            throw new OrderException();
        }

        return $this->parameters['items'];
    }

    /**
     * Sets our items
     *
     * @param $array
     */

    public function setItems( $array )
    {

        if( empty( $this->parameters ) )
        {

            $this->parameters = array();
        }

        $this->parameters['items'] = $array;
    }

    /**
     * Gets our advanced options
     *
     * @return mixed
     */

    public function getAdvancedOptions()
    {

        if( isset( $this->parameters['advancedOptions'] ) == false )
        {

            throw new OrderException();
        }

        return $this->parameters['advancedOptions'];
    }

    /**
     * Sets our advanced options
     *
     * @param $array
     */

    public function setAdvancedOptions( $array )
    {

        if( empty( $this->parameters ) )
        {

            $this->parameters = array();
        }

        $this->parameters['advancedOptions'] = $array;
    }

    /**
     * Creates the orders
     *
     * @return string
     */

    public function createOrder()
    {

        if( empty( $this->parameters ) )
        {

            throw new OrderException();
        }

        $request = new Request();

        $this->setHeaders( $request );

        $request->setBody( $this->parameters );

        if( $request->canPreformRequest() === false )
        {

            throw new OrderException();
        }

        $result = $request->post( $this->address );

        if( empty( $result ) )
        {

            throw new OrderException();
        }

        return $result;
    }

    /**
     * Sets the headers
     *
     * @param Request $request
     */

    private function setHeaders( Request $request )
    {

        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $this->authenticator->getRaw()
        );

        $request->setHeadersFromArray( $headers );
    }
}