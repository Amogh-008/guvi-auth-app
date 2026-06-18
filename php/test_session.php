<?php

require_once "config.php";

$redis->set(
    "test_key",
    "Redis Working"
);

echo $redis->get("test_key");