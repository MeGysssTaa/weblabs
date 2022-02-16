<?php

$regex = "/(\d)+/";
$str = "a1b2c3";
echo preg_replace_callback($regex, fn($matches) => intval($matches[0]) ** 2, $str);
