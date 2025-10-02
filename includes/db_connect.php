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
?>