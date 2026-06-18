<?php

require_once "config.php";

$sessionId =
$_POST['sessionId'];

$sessionData =
$redis->get(
"session:$sessionId"
);

if(!$sessionData){

    echo json_encode([
        "success"=>false
    ]);

    exit;
}

$sessionData =
json_decode(
$sessionData,
true
);

$userId =
$sessionData['userId'];

$stmt =
$mysqli->prepare(
"SELECT fullname,email
FROM users
WHERE id=?"
);

$stmt->bind_param(
"i",
$userId
);

$stmt->execute();

$user =
$stmt
->get_result()
->fetch_assoc();

$profile =
$profilesCollection
->findOne([
'userId'=>$userId
]);

echo json_encode([

    "success"=>true,

    "fullname"=>$user['fullname'],

    "email"=>$user['email'],

    "age"=>$profile['age'] ?? '',

    "dob"=>$profile['dob'] ?? '',

    "contact"=>$profile['contact'] ?? '',

    "address"=>$profile['address'] ?? ''

]);