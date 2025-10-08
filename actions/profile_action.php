<?php
session_start();
include("../includes/db_connect.php"); 

$user_id = $_SESSION['user_id'];
if (!$user_id) {
    header("Location: login.php");
    exit();
}
$user_sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch trips
$trip_sql = "SELECT * FROM trips WHERE user_id = ?";
$stmt = $conn->prepare($trip_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$trips = $stmt->get_result();

// Fetch reviews
$review_sql = "SELECT r.*, u.name as reviewer_name 
               FROM reviews r 
               JOIN users u ON r.user_id = u.user_id
               WHERE r.reviewed_user = ?";
$stmt = $conn->prepare($review_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reviews = $stmt->get_result();
session_abort();
?>