<?php

require_once "config.php";

print_r(
$redis->keys("*")
);
