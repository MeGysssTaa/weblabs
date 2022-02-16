<?php

if (!isset($_POST["firstName"]) || !isset($_POST["lastName"]) || !isset($_POST["age"])) {
    http_response_code(400);
    echo "Bad Request";
    return;
}

if (!session_start()) {
    http_response_code(500);
    echo "Internal Server Error";
    return;
}

$_SESSION["firstName"] = $_POST["firstName"];
$_SESSION["lastName"] = $_POST["lastName"];
$_SESSION["age"] = $_POST["age"];

header("Refresh:3; url=../b2-greeting.php");
