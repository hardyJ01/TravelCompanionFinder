<?php
include("../includes/db_connect.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
if (!$user_result) {
    die("Error executing query: " . $stmt->error);
}

$user = $user_result->fetch_assoc();
if (!$user) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>
<link rel="stylesheet" href="../assets/css/editprofile.css">
</head>
<body>

<div class="container">
    <div class="edit-profile-card">
        <h2>Edit Your Profile</h2>
        <form action="../actions/editprofile_action.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" value="<?php echo $user['age']; ?>">
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="Male" <?php if($user['gender']=="Male") echo "selected"; ?>>Male</option>
                    <option value="Female" <?php if($user['gender']=="Female") echo "selected"; ?>>Female</option>
                    <option value="Other" <?php if($user['gender']=="Other") echo "selected"; ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Language</label>
                <input type="text" name="language" value="<?php echo $user['language']; ?>">
            </div>

            <div class="form-group">
                <label>Preferences</label>
                <textarea name="preferences"><?php echo $user['preferences']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Bio</label>
                <textarea name="bio"><?php echo $user['bio']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" value="<?php echo $user['location']; ?>">
            </div>
            <div class="form-group">
                <label>Profile Picture</label><br>
                <img src="uploads/<?php echo $user['profile_pic']; ?>" alt="Profile" width="120" height="120"><br><br>
                <input type="file" name="profile_pic" accept="image/*">
            </div>
            <button type="submit" class="btn-save">Update Profile</button>
        </form>
    </div>
</div>

</body>
</html>
