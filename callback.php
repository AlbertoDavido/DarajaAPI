<?php
header('Content-Type: application/json');
$payload = file_get_contents('php://input');
file_put_contents('callbacks.log', $payload.PHP_EOL, FILE_APPEND);
echo json_encode(["ResultCode" => 0, "ResultDesc" => "Success"]);











