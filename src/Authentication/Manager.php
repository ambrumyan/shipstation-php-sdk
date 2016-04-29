<?php
namespace Shipstation\Authentication;

/**
 * Lewis Lancaster 2016
 *
 * Class Manager
 *
 * @package Shipstation\Authentication
 */

use Shipstation\Authentication\Structures\Authenticator;
use Shipstation\Exception\AuthenticatorException;

class Manager
{

    /**
     * @var Authenticator
     */

    protected $authenticator;

    /**
     * Manager constructor.
     *
     * @param Authenticator $authenticator
     */

    public function __construct( Authenticator $authenticator )
    {

        if( $authenticator instanceof Authenticator == false )
        {

            throw new AuthenticatorException();
        }

        $this->authenticator = $authenticator;
    }

    /**
     * Gets the header.
     *
     * @return string
     */

    public function getHeader()
    {

        $result = $this->authenticator->getData();

        if( $result == null || is_string( $result ) == false )
        {

            throw new AuthenticatorException();
        }

        return 'Authorization: Basic ' . $result . "\r\n";
    }

    /**
     * Gets the raw output
     *
     * @return mixed
     */

    public function getRaw()
    {

        return $this->authenticator->getData();
    }
}