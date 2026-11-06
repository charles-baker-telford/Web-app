<?php 
// 2. Database configuration details
$host    = 'localhost';
$db      = '105568';
$user    = '105568';
$pass    = 'manic'; // move this to below www root in production
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    // 3. Establish the PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo json_encode([
        'status' => 'connected to database',
        'message' => 'Database connection success.'
    ]);
} catch (\PDOException $e) {
    // Return a JSON error if the database connection fails
    echo json_encode([
        'status' => 'error connecting to database',
        'message' => 'Database connection failed.'
    ]);
    exit;
}

?>