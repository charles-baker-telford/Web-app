<?php
// Turn on all error reporting
error_reporting(E_ALL);

// Force PHP to output errors to the browser screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: application/json; charset=utf-8');
$output = ['messages' => [], 'status' => []];

//connect to database
require_once("connection.php");
session_start();

//create the question to ask the database
$full_name = $_POST["full_name"];
$date_of_birth = $_POST["date_of_birth"];

//$output['status'][] = ["type" => "email", "content" => $username];
//$output['status'][] = ["type" => "password", "content" => $password];

// Use a prepared statement with valid INSERT syntax
$stmt = $pdo->prepare("INSERT INTO profile (user_id, full_name, date_of_birth) VALUES (:user_id, :full_name, :date_of_birth)
ON DUPLICATE KEY UPDATE 
full_name = VALUES(full_name),
date_of_birth = VALUES(date_of_birth)");

// Execute the query safely with bound parameters
$stmt->execute([
    "user_id" => $_SESSION['authenticated_user'],
    'full_name' => $full_name,
    'date_of_birth' => $date_of_birth
]);

if ($stmt->rowCount() == 1) {
    //a new row was inserted
} elseif ($stmt->rowCount() == 2) {
    //an existing row was updated
} elseif ($stmt->rowCount() == 0) {
    //an existing row was updated but no changes made)
}
//report progress


echo json_encode($output); 
?>

