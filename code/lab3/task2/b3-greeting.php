<?php

if (!session_start()) {
    http_response_code(500);
    echo "Internal Server Error";
    return;
}

if (!isset($_SESSION["firstName"]) || !isset($_SESSION["lastName"]) || !isset($_SESSION["age"])) {
    http_response_code(401);
    echo "Unauthorized";
    return;
}

echo "Hiii {$_SESSION['age']} years old {$_SESSION['firstName']} {$_SESSION['lastName']}!!!";
