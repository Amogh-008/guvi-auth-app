<?php

require_once "config.php";

$fullname =
trim($_POST['fullname']);

$email =
trim($_POST['email']);

$password =
trim($_POST['password']);

if(
empty($fullname) ||
empty($email) ||
empty($password)
){
    exit("All fields required");
}

/* CHECK EMAIL */

$checkStmt =
$mysqli->prepare(
"SELECT id FROM users
WHERE email=?"
);

$checkStmt->bind_param(
"s",
$email
);

$checkStmt->execute();

$result =
$checkStmt->get_result();

if(
$result->num_rows > 0
){
    exit(
    "Email already exists"
    );
}

/* HASH PASSWORD */

$hashedPassword =
password_hash(
$password,
PASSWORD_BCRYPT
);

/* INSERT USER */

$stmt =
$mysqli->prepare(
"INSERT INTO users
(fullname,email,password)
VALUES(?,?,?)"
);

$stmt->bind_param(
"sss",
$fullname,
$email,
$hashedPassword
);

if(
$stmt->execute()
){

    $userId =
    $stmt->insert_id;

    /* CREATE PROFILE */

    $profilesCollection
    ->insertOne([

        'userId'=>$userId,
        'age'=>'',
        'dob'=>'',
        'contact'=>'',
        'address'=>''

    ]);

    echo
    "Registration Successful";

}else{

    echo
    "Registration Failed";

}