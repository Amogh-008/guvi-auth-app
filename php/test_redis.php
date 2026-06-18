<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Predis\Client;

try{

    $redis = new Client([
        'scheme' => 'tcp',
        'host' => '127.0.0.1',
        'port' => 6379
    ]);

    $redis->set('test', 'GUVI');

    echo $redis->get('test');

}catch(Exception $e){

    echo $e->getMessage();

}