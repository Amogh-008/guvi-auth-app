<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use Predis\Client as RedisClient;

/* MYSQL */

$mysqli = new mysqli(
    "localhost",
    "root",
    "",
    "guvi_auth"
);

if ($mysqli->connect_error) {
    die("MySQL Connection Failed");
}

/* MONGODB */

$mongoClient = new Client(
    "mongodb://localhost:27017"
);

$mongoDB = $mongoClient->guvi_auth;

$profilesCollection =
$mongoDB->profiles;

/* REDIS */

$redis = new RedisClient([
    'scheme' => 'tcp',
    'host' => '127.0.0.1',
    'port' => 6379
]);