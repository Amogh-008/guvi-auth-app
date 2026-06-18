<?php

require_once "config.php";

$email =
trim($_POST['email']);

$password =
trim($_POST['password']);

$stmt =
$mysqli->prepare(
"SELECT * FROM users
WHERE email=?"
);

$stmt->bind_param(
"s",
$email
);

$stmt->execute();

$result =
$stmt->get_result();

if(
$result->num_rows === 0
){

    echo json_encode([

        "success"=>false,
        "message"=>"User not found"

    ]);

    exit;

}

$user =
$result->fetch_assoc();

if(
!password_verify(
$password,
$user['password']
)
){

    echo json_encode([

        "success"=>false,
        "message"=>"Wrong Password"

    ]);

    exit;

}

/* CREATE SESSION */

$sessionId =
bin2hex(
random_bytes(16)
);

$redis->set(

    "session:$sessionId",

    json_encode([

        "userId"=>$user['id'],
        "email"=>$user['email']

    ])

);

/* EXPIRE AFTER 1 HOUR */

$redis->expire(

    "session:$sessionId",

    3600

);

echo json_encode([

    "success"=>true,
    "sessionId"=>$sessionId

]);