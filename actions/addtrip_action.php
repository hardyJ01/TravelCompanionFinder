<?php
session_start();
include("../includes/db_connect.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
try{
    $user_id = $_SESSION['user_id'];

    $destination = $_POST['Destination'];
    $from_location = $_POST['From_Location'];
    $start_date = $_POST['Start_Date'];
    $end_date = $_POST['End_Date'];
    $budget = $_POST['Budget'];
    $preferences = $_POST['preferences'];
    $type = $_POST['Type'];
    $sql = "INSERT INTO trips (user_id, destination, fromlocation, start_date, end_date, budget, preferences, type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssiss", $user_id, $destination, $from_location, $start_date, $end_date, $budget, $preferences, $type);
    if($end_date < $start_date){
        throw new Exception("End Date cannot be earlier than Start Date.");
    }
    if ($stmt->execute()) {
        header("Location: ../src/profile.php?message=Trip added successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        throw new Exception("Error adding trip: " . $stmt->error);
    }
} catch (Exception $e) {
    header("Location: ../src/addtrip.php?error=" . urlencode($e->getMessage()));
    exit();
}
