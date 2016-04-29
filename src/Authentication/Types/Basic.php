<?php
namespace Shipstation\Authentication\Types;

/**
 * Lewis Lancaster 2016
 *
 * Class Basic
 *
 * @package Shipstation\Authentication\Types
 */

use Shipstation\Authentication\Structures\Authenticator;

class Basic implements Authenticator
{

    /**
     * @var string
     */

    protected $apikey;

    /**
     * @var string
     */

    protected $apisecret;

    /**
     * Api constructor.
     *
     * @param $apikey
     *
     * @param $apisecret
     */

    public function __construct( $apikey, $apisecret )
    {

        $this->apikey = $apikey;

        $this->apisecret = $apisecret;
    }

    /**
     * Gets the data for this authentication method
     *
     * @return string
     */

    public function getData()
    {

        return base64_encode( $this->apikey . ":" . $this->apisecret );
    }
}