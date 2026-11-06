<?php
// Turn on all error reporting
//error_reporting(E_ALL);

// Force PHP to output errors to the browser screen
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

header('Content-Type: application/json; charset=utf-8');
$output = ['messages' => [], 'status' => []];

//connect to database
require_once("connection.php");

//create the question to ask the database
$username = $_POST["email"];
$password = $_POST["password"];

//$output['status'][] = ["type" => "email", "content" => $username];
//$output['status'][] = ["type" => "password", "content" => $password];

$stmt = $pdo->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($user) {
    // Positive result: Exactly one record was found and returned
    $message = "Success! Found user: " . $user['user_id'];
    $output['status'][] = ["type" => "login", "content" => $message];
} else {
    // Negative result: No records matched
    $output['status'][] = ["type" => "login", "content" => "Invalid credentials"];
}
//process the answer
if ($user) {
    session_start();
    $_SESSION["authenticated_user"] = $user['user_id'];
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

