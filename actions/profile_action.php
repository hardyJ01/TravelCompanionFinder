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

// --- Update Old Trip Statuses (Efficiently) ---
// This single query updates all trips that have ended and are still 'active'.
// Assumes 'active' is the default status.
$update_sql = "UPDATE trips SET status = 'completed' WHERE user_id = ? AND end_date < CURDATE() AND status = 'active'";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $user_id);
$update_stmt->execute();
$update_stmt->close();

// --- Fetch Active Trips ---
$active_trip_sql = "SELECT * FROM trips WHERE user_id = ? AND status = 'active' ORDER BY start_date ASC";
$stmt = $conn->prepare($active_trip_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$active_trips = $stmt->get_result(); // This variable will be used in profile.php


// ----- Fetch the Active Trips with Companion Details for src/companions.php -----
$companions_sql = "SELECT t.*, u.name, u.profile_pic,u.language 
                   FROM trips t 
                   JOIN users u ON t.user_id = u.user_id 
                   WHERE t.status = 'active' and u.user_id<>?
                   ORDER BY t.start_date ASC"; 
$stmt = $conn->prepare($companions_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$active_trips_companions = $stmt->get_result(); // This variable will be used in src/companions.ph


// --- Fetch Completed Trips ---
$completed_trip_sql = "SELECT * FROM trips WHERE user_id = ? AND status = 'completed' ORDER BY start_date DESC";
$stmt = $conn->prepare($completed_trip_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$completed_trips = $stmt->get_result(); // This variable will be used in profile.php

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