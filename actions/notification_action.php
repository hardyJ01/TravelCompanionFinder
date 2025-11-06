<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../includes/db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../src/login.php");
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Read from $_GET parameters (from the links in h.php)
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $connection_id = intval($_GET['id']);
        
        $new_status = '';
        if ($action === 'accept') {
            $new_status = 'accepted';
        } elseif ($action === 'reject') {
            $new_status = 'rejected';
        }

        if ($new_status) {
            $update_sql = "UPDATE companions 
                           SET status = ? 
                           WHERE request_id = ? AND to_user = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sii", $new_status, $connection_id, $user_id);
            
            if ($stmt->execute()) {
                $_SESSION['notification_message'] = "Request {$new_status} successfully.";
            } else {
                throw new Exception("Failed to update status: " . $stmt->error);
            }
        } else {
             $_SESSION['notification_message'] = "Invalid action.";
        }
    } else {
        // If no action is specified, just redirect home.
        $_SESSION['notification_message'] = "No action performed.";
    }

} catch (Exception $e) {
    // Store the error message in the session to display on h.php
    $_SESSION['notification_message'] = "Error: " . $e->getMessage();
}

// No matter what happens, redirect back to the home page.
header("Location: ../src/h.php");
exit();
?>