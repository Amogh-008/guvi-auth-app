<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

try {

    $client = new Client("mongodb://localhost:27017");

    $db = $client->guvi_auth;

    echo "MongoDB Connected Successfully";

} catch(Exception $e){

    echo $e->getMessage();
}