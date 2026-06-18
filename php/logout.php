<?php

require_once "config.php";

$sessionId =
$_POST['sessionId'];

$redis->del(
"session:$sessionId"
);

echo
"Logged Out";