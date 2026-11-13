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

//create the question to ask the database
$username = $_POST["email"];
$password = $_POST["password"];

//$output['status'][] = ["type" => "email", "content" => $username];
//$output['status'][] = ["type" => "password", "content" => $password];

// Hash the password securely before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Use a prepared statement with valid INSERT syntax
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

// Execute the query safely with bound parameters
$stmt->execute([
    'username' => $username,
    'password' => $hashedPassword,
]);

// Get the ID of the newly created user (optional)
$newUserId = $pdo->lastInsertId();

if ($newUserId) {
    // Positive result: Exactly one record was created
    $message = "Success! Created user: " . $newUserId;
    $output['status'][] = ["type" => "login", "content" => $message];
} else {
    // Negative result: No records created
    $output['status'][] = ["type" => "login", "content" => "Invalid details"];
}
//process the answer
 if ($newUserId) {
    session_start();
    $_SESSION["authenticated_user"] = $newUserId;
    $output['status'][] = ["type" => "authenticated", "content" => true];
} else {
    $output['status'][] = ["type" => "authenticated", "content" => false];
    // check if there is currently a session
    if (isset($_SESSION) || isset($_COOKIE[session_name()])) {
        session_start();
        $output['status'][] = ["type" => "login", "content" => "destroying session and cookie"];
        // Unset all local session global variables
        $_SESSION = [];
        // Clear the session cookie parameters from the browser
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Destroy the actual session file data stored on the server
        session_destroy();
    }    
}
//report progress


echo json_encode($output); 
?>

