<?php 
// 2. Database configuration details
$host    = 'localhost';
$db      = '105568';
$user    = '105568';
// $pass    = 'manic'; // move this to below www root in production

// Load configuration as an array. Use the actual location of your configuration file
// current directory is var/www/$dbUsername/scripts
// config.ini file needs to be owned by www-data and permissions 0640 

    $config = parse_ini_file('../../../config.ini'); 
    
    $pass = $config[$user];

$charset = 'utf8mb4';

// DSN is data source name 
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    // 3. Establish the PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);
    $output['messages'][] = ["type" => "message", "content" => "Database connection success."];
    $output['status'][] = ["type" => "db_connection", "content" => "connected to database."];
    
} catch (\PDOException $e) {
    // Return a JSON error if the database connection fails
    $output['messages'][] = ["type" => "error", "content" => "Database connection failed."];
    $errorMessage = "failed to connect to database.".$e->getMessage();
    $output['status'][] = ["type" => "db_connection", "content" => $errorMessage];
    
    exit;
}

?>