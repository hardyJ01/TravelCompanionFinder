<?php
session_start();
include("../includes/db_connect.php");

header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        throw new Exception('Invalid JSON data received');
    }

    $from_user = $_SESSION['user_id'];
    $action = $input['action'] ?? '';

    switch ($action) {
        case 'send_message':
            if (!isset($input['to_user']) || !isset($input['content'])) {
                throw new Exception('Missing required fields');
            }

            $to_user = intval($input['to_user']);
            $content = trim($input['content']);

            error_log("Debug - To User: $to_user");
            $check_sql = "SELECT COUNT(*) as connection_exists 
                         FROM companions 
                         WHERE status = 'accepted' 
                         AND (
                             (from_user = ? AND to_user = ?) 
                             OR 
                             (from_user = ? AND to_user = ?)
                         )";
            
            $check_stmt = $conn->prepare($check_sql);
            if (!$check_stmt) {
                error_log("DB prepare failed (check): " . $conn->error);
                throw new Exception('Database error while checking connection');
            }

            $check_stmt->bind_param("iiii", $from_user, $to_user, $to_user, $from_user);
            if (!$check_stmt->execute()) {
                error_log("DB execute failed (check): " . $check_stmt->error);
                throw new Exception('Error checking connection status');
            }

            $result = $check_stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Debug the result
            error_log("Debug - Connection count: " . $row['connection_exists']);

            if ($row['connection_exists'] == 0) {
                throw new Exception('You are not connected with this user');
            }

            $check_stmt->close();


            // Insert the message
            $insert_sql = "INSERT INTO messages (from_user, to_user, content) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            if (!$stmt) {
                throw new Exception('Database error: ' . $conn->error);
            }

            $stmt->bind_param("iis", $from_user, $to_user, $content);
            
            if (!$stmt->execute()) {
                throw new Exception('Failed to send message: ' . $stmt->error);
            }

            echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
            break;

        case 'get_messages':
            if (!isset($input['to_user'])) {
                throw new Exception('Missing user ID');
            }

            $other_user = intval($input['to_user']);

            $messages_sql = "SELECT m.*, 
                           m.from_user = ? as from_me,
                           u.name as sender_name 
                           FROM messages m 
                           JOIN users u ON m.from_user = u.user_id 
                           WHERE ((m.from_user = ? AND m.to_user = ?) 
                           OR (m.from_user = ? AND m.to_user = ?))
                           AND m.status = 'active' 
                           ORDER BY m.created_at ASC";

            $stmt = $conn->prepare($messages_sql);
            if (!$stmt) {
                throw new Exception('Database error: ' . $conn->error);
            }

            $stmt->bind_param("iiiii", $from_user, $from_user, $other_user, $other_user, $from_user);
            $stmt->execute();
            $result = $stmt->get_result();

            $messages = [];
            while ($row = $result->fetch_assoc()) {
                $messages[] = [
                    'msg_id' => $row['msg_id'],
                    'content' => $row['content'],
                    'from_me' => (bool)$row['from_me'],
                    'created_at' => $row['created_at']
                ];
            }

            echo json_encode([
                'success' => true,
                'messages' => $messages
            ]);
            break;

        default:
            throw new Exception('Invalid action specified');
    }

} catch (Exception $e) {
    error_log('Chat error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>