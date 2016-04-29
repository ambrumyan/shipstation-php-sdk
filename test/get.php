<?php

require_once "../vendor/autoload.php";

use Shipstation\Orders\Get;
use Shipstation\Authentication\Types\Basic;

$authenticator = new Basic("apikey","apisecret");

$get = new Get( $authenticator );

$get->setSearchParameters( array(
    "orderStatus" => 'awaiting_shipment'
));

print_r( $get->getOrder() );