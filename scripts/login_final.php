<?php
// 1. Force the response header to be JSON
header('Content-Type: application/json; charset=utf-8');



// 4. Validate that the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
    exit;
}

// 5. Sanitize and assign input variables
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// 6. Ensure fields are not empty
if (empty($username) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please provide both username and password.'
    ]);
    exit;
}

try {
    // 7. Prepare and execute the SQL query to find the user
    // (Select only the id and the hashed password for performance)
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // 8. Verify the user exists and the password matches the stored hash
    if ($user && password_verify($password, $user['password_hash'])) {
        
        // Optional: Start a session and save the user data here
        // session_start();
        // $_SESSION['user_id'] = $user['id'];

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful.',
            'user_id' => $user['id']
        ]);
        
    } else {
        // Generic error message to prevent username enumeration exploits
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid username or password.'
        ]);
    }

} catch (\PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred while processing your request.'
    ]);
}
