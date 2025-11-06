<?php
$env = parse_ini_file(__DIR__ . '/../.env');
$host = $env['host'];
$db = $env['db'];
$user = $env['user'];
$pass = $env['pass'];

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}
// Check connection
if($conn->connect_error){
    
    http_response_code(500); // Internal Server Error
    error_log("Connection failed: ". $conn->connect_error);
    
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Set charset
$conn->set_charset("utf8mb4");
?>
