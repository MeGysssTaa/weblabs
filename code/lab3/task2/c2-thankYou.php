<?php


if (!session_start()) {
    http_response_code(500);
    echo "Internal Server Error";
    return;
}

echo buildResponse();


function buildResponse(): string {
    $response = "<h1>Thank you!</h1><br>";
    $response .= "<ul>";

    foreach ($_SESSION as $k => $v)
        $response .= "<li>" . $k . "=" . $v;

    $response .= "</ul>";

    return $response;
}
