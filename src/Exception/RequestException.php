<?php
namespace Shipstation\Exception;

/**
 * Lewis Lancaster 2016
 *
 * Class RequestException
 *
 * @package Shipstation\Exception
 */

use Exception;
use RuntimeException;
use stdClass;

class RequestException extends RuntimeException
{

    /**
     * @var string
     */

    protected $address;

    /**
     * @var stdClass;
     */

    protected $context;

    /**
     * RequestException constructor.
     *
     * @param null $message
     *
     * @param null $address
     *
     * @param null $context
     *
     * @param null $code
     *
     * @param Exception|null $previous
     */

    public function __construct($message=null, $address=null, $context=null, $code=null, Exception $previous=null)
    {

        $this->address = $address;

        $this->context = $context;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Gets the address
     *
     * @return int
     */

    public function getAddress()
    {

        return $this->address;
    }

    /**
     * Gets the context
     *
     * @return Exception
     */

    public function getContext()
    {

        return $this->context;
    }
}