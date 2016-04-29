<?php

require_once "../vendor/autoload.php";

use Shipstation\Orders\Get;
use Shipstation\Authentication\Types\Basic;

$authenticator = new Basic("44dc77c3e5b44e859b5e6e5b9ec5d746","db7633123abb411b98f47e6c28b0a6cb");

$get = new Get( $authenticator );

$get->setSearchParameters( array(
    "orderStatus" => 'awaiting_shipment'
));
