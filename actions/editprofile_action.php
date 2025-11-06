<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../src/login.php');
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Get current user's profile pic
    $get_current_pic = "SELECT profile_pic FROM users WHERE user_id = ?";
    $stmt_pic = $conn->prepare($get_current_pic);
    $stmt_pic->bind_param("i", $user_id);
    $stmt_pic->execute();
    $result = $stmt_pic->get_result();
    $current_user = $result->fetch_assoc();
    
    // Handle file upload first
    $profile_pic = '';
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_pic']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            $new_filename = 'profile_' . $user_id . '.' . $file_ext;
            $upload_path = '../assets/images/profile_pics/' . $new_filename;
            
            if (!file_exists('../assets/images/profile_pics/')) {
                mkdir('../assets/images/profile_pics/', 0777, true);
            }
            
            // Delete old profile picture if it exists and is different from default
            if ($current_user && $current_user['profile_pic'] && 
                file_exists('../' . $current_user['profile_pic']) && 
                $current_user['profile_pic'] != 'assets/images/default-profile.png') {
                unlink('../' . $current_user['profile_pic']);
            }
            
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_path)) {
                $profile_pic = 'assets/images/profile_pics/' . $new_filename;
            }
        }
    }

    // Prepare the SQL query
    $sql = "UPDATE users SET 
            name = ?, 
            email = ?, 
            age = ?, 
            gender = ?, 
            language = ?, 
            preferences = ?, 
            bio = ?,
            location= ?";

    
    // Add profile_pic to update if a new image was uploaded
    if ($profile_pic != '') {
        $sql .= ", profile_pic = ?";
    }
    
    $sql .= " WHERE user_id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    if ($profile_pic != '') {
        $stmt->bind_param("ssisssssis", 
            $_POST['name'],
            $_POST['email'],
            $_POST['age'],
            $_POST['gender'],
            $_POST['language'],
            $_POST['preferences'],
            $_POST['bio'],
            $_POST['location'],
            $profile_pic,
            $user_id
        );
    } else {
        $stmt->bind_param("ssisssssi", 
            $_POST['name'],
            $_POST['email'],
            $_POST['age'],
            $_POST['gender'],
            $_POST['language'],
            $_POST['preferences'],
            $_POST['bio'],
            $_POST['location'],
            $user_id
        );
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: ../src/profile.php");
        exit();
    } else {
        throw new Exception("Error executing statement: " . $stmt->error);
    }

} catch (Exception $e) {
    $_SESSION['error_message'] = "Error updating profile: " . $e->getMessage();
    header("Location: ../src/editprofile.php");
    exit();
}
?>