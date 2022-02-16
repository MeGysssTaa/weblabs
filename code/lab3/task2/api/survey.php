<?php

if (count($_POST) == 0) {
    http_response_code(400);
    echo "Bad Request";
    return;
}

if (!session_start()) {
    http_response_code(500);
    echo "Internal Server Error";
    return;
}

$_SESSION = $_POST;
header("Refresh:3; url=../c2-thankYou.php");
