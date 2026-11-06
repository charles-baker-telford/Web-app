<?php
header('Content-Type: application/json; charset=utf-8');


$output = ['messages' => [], 'status' => []];

$output['messages'][] = ["type" => "message", "content" => "This is a default message"];
$output['messages'][] = ["type" => "confirm", "content" => "This is a confirm message"];
$output['messages'][] = ["type" => "warn", "content" => "This is a warning message"];
$output['messages'][] = ["type" => "error", "content" => "This is an error message"];


echo json_encode($output);
?>

