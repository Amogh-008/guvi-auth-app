<?php

require_once "config.php";

$sessionId =
$_POST['sessionId'];

$sessionData =
$redis->get(
"session:$sessionId"
);

if(!$sessionData){

    exit("Session Expired");
}

$sessionData =
json_decode(
$sessionData,
true
);

$userId =
$sessionData['userId'];

$profilesCollection
->updateOne(

    [
        'userId'=>$userId
    ],

    [
        '$set'=>[
            'age'=>$_POST['age'],
            'dob'=>$_POST['dob'],
            'contact'=>$_POST['contact'],
            'address'=>$_POST['address']
        ]
    ]

);

echo
"Profile Updated";