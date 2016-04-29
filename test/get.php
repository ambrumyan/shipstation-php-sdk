<?php

require_once "../vendor/autoload.php";

use Shipstation\Orders\Get;
use Shipstation\Authentication\Types\Api;

$api = new Api("apikey","apisecret");

$get = new Get( $api );

$get->setSearchParameters( array(
    "orderStatus" => 'awaiting_shipment'
));

print_r( $get->getOrder() );