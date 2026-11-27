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
// check here for valid session and user id

$user_id = $_SESSION['authenticated_user'];

try {

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = $data['id'];
    $text = $data['text'];
    // To prevent a hacker fom altering a column name to include malicious code we need to
    // check that the $id received from the client is actually a valid column name in the database.
    // here we whitelist the column names that we are allowing the user to modify the content of.
    $allowedColumns = ["date_of_birth", "address", "full_name" ];
    if (!in_array($id, $allowedColumns, true)) {
        echo "fail";
        exit();
    }

    // to prevent the database delivering values that include malicious JavaScript to perform XSS activity,
    // we need to remove encode special characters like < and > before displaying in browser. In this webapp
    // the data is displayed using textContent rather than innerHTML which is 100% protection against XSS
    // If we were to use span.innerHTML this would cause a vulnerability. 
    // it is not required to use htmlspecialchars()




    $sql = "UPDATE profile
            SET $id = :value
            WHERE user_id = $user_id";
            
    // using prepared statements prevents SQL injection by keeping the user input apart from the query 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
            ':value' => $text
    ]);
    echo "Record updated successfully";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

//echo json_encode(); 
?>

