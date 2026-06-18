<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");

$db = $client->guvi_auth;

$result = $db->profiles->insertOne([
    'userId' => 1,
    'age' => '',
    'dob' => '',
    'contact' => '',
    'address' => ''
]);

echo "Inserted";