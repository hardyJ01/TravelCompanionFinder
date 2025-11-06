<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Use include_once to prevent conflicts, and use __DIR__ for a reliable path
include_once(__DIR__ . "/../includes/db_connect.php"); 

$connectedUsers = [];
if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];

    // Step 1: Find all user IDs this person has an 'accepted' connection with.
    $sql = "SELECT 
                CASE
                    WHEN from_user = ? THEN to_user
                    WHEN to_user = ? THEN from_user
                END AS other_user_id
            FROM companions 
            WHERE (from_user = ? OR to_user = ?) AND status = 'accepted'";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $current_user_id, $current_user_id, $current_user_id, $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $user_ids = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['other_user_id']) {
            $user_ids[] = $row['other_user_id'];
        }
    }
    $stmt->close();
    
    // Step 2: Now fetch the user details for those IDs.
    if (!empty($user_ids)) {
        // Create placeholders for the IN clause (e.g., ?,?,?)
        $placeholders = implode(',', array_fill(0, count($user_ids), '?'));
        // Create the types string (e.g., "iii")
        $types = str_repeat('i', count($user_ids));
        
        // --- IMPORTANT: Ensure user_id is explicitly selected ---
        $user_sql = "SELECT user_id, name as sender_name, profile_pic FROM users WHERE user_id IN ($placeholders)";
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->bind_param($types, ...$user_ids);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        
        while ($user_row = $user_result->fetch_assoc()) {
            // Explicitly assign to ensure the key exists
            $connectedUsers[] = [
                'user_id' => $user_row['user_id'],
                'sender_name' => $user_row['sender_name'],
                'profile_pic' => $user_row['profile_pic'] // Pass this along
            ];
        }
        $user_stmt->close();
    }
}
// This file is included by chat.php, so it just needs to provide the $connectedUsers array.
?>