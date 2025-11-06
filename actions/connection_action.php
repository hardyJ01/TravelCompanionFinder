<?php
session_start();
include("../includes/db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

try{
    // Ensure integers
    $sender_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    $receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : 0;

    // Check if connection already exists
    $check_sql = "SELECT * FROM companions 
                  WHERE (from_user = ? AND to_user = ?) 
                  OR (from_user = ? AND to_user = ?)";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../src/companions.php");
        exit();
    }

    // Insert new connection request
    $query= "INSERT INTO companions (from_user, to_user) VALUES (?,?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        error_log("Prepare failed (insert): " . $conn->error);
        $_SESSION['error'] = "Database error.";
        header("Location: ../src/companions.php");
        exit();
    }
    $stmt->bind_param("ii", $sender_id, $receiver_id);
    if ($stmt->execute()) {
        header("Location: ../src/companions.php");
        exit();
    } else {
        throw new Exception("Error adding companion: " . $stmt->error);
    }  
}
catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../src/companions.php");
    exit();
}