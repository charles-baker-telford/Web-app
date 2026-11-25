<?php
// Turn on all error reporting
error_reporting(E_ALL);

// Force PHP to output errors to the browser screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: application/json; charset=utf-8');
$output = ['messages' => [], 'status' => [], 'data' => []];

try {
    //connect to database
    require_once("connection.php");
    session_start();
    if (empty($_SESSION['authenticated_user'])) {
        $output['status'][] = ["type" => "authenticated", "content" => false];
        echo json_encode($output); 
        exit();
    }
    $user_id = $_SESSION['authenticated_user'];

    
    //create the question to ask the database

    // Use a prepared statement for consistency despite no user entered data
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE user_id = $user_id");

    // Execute the query 
    $stmt->execute();

    $results = $stmt->fetchAll();

    // 5. Output as JSON into our message structure
    $output['data'][] = ['profile' => $results];

} catch (PDOException $e) {
    // Return a proper HTTP error code and JSON error message
    http_response_code(500);
    $output['status'][] = ["type" => "db_connection", "content" => "Database query failed"];
}


echo json_encode($output); 
?>

