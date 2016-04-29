<?php
namespace Shipstation\Orders;

/**
 * Lewis Lancaster 2016
 *
 * Class Get
 *
 * @package Shipstation\Orders
 */

use Shipstation\Authentication\Structures\Authenticator;
use Shipstation\Exception\OrderException;
use Shipstation\Authentication\Manager;
use Shipstation\Request\Manager as Request;

class Get
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
     * The address for this call
     *
     * @var string
     */

    protected $address = "https://ssapi.shipstation.com/orders";

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
     * Sets the search parameters
     *
     * @param $array
     */

    public function setSearchParameters( $array )
    {

        $this->parameters = $array;
    }

    /**
     * Gets the search parameters currently set
     *
     * @return array
     */

    public function getSearchParameters()
    {

        return $this->parameters;
    }

    /**
     * Gets the order
     *
     * @return string
     */

    public function getOrders()
    {

        $request = new Request();

        if( $request == null )
        {

            throw new OrderException();
        }

        $this->setHeaders( $request );

        $request->setBody( $this->parameters );

        if( $request->canPreformRequest() === false )
        {

            throw new OrderException();
        }

        $result = $request->get( $this->address );

        if( $result == null )
        {

            throw new OrderException();
        }

        return json_decode( $result, true );
    }

    /**
     * Gets the first order, or if the index is not null, returns that index.
     *
     * @param null $index
     *
     * @return mixed
     */

    public function getOrder( $index=null )
    {

        $result = $this->getOrders();

        if( empty( $result ) )
        {

            throw new OrderException();
        }

        if( $index !== null )
        {

            return $result["orders"][ $index ];
        }

        return reset( $result["orders"] );
    }

    /**
     * Sets the headers for our request
     *
     * @param Request $request
     */

    private function setHeaders( Request $request )
    {

        $headers = $this->authenticator->getHeader();

        if( $headers == null )
        {

            throw new OrderException();
        }

        $request->setHeaders( $headers );
    }
}