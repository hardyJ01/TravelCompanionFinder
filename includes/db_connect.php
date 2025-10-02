<?php
$host = 'localhost';
$db = 'travel_circle_db';
$user = 'root';
$pass = 'Hardip#20';

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}
// echo "Connected successfully";
?>