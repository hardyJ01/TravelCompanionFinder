<?php
include("../includes/db_connect.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addtrip</title>
    <link rel="stylesheet" href="../assets/css/editprofile.css">
</head>
<body>
    <div class="container">
    <div class="edit-profile-card">
        <h2>Add Your Trip</h2>
        <form action="../actions/addtrip_action.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Destination</label>
                <input type="text" name="Destination" required>
            </div>

            <div class="form-group">
                <label>From Location</label>
                <input type="text" name="From_Location" required>
            </div>

            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="Start_Date" required>
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="End_Date" required>
            </div>

            <div class="form-group">
                <label>Budget</label>
                <input type="float" name="Budget" value="0.0">
            </div>
            <div class="form-group">
                <label>Language</label>
                <input type="text" name="Language">
            </div>
            <div class="form-group">
                <label>Preferences</label>
                <textarea name="preferences"></textarea>
            </div>
            <div class="form-group">
                <label>Type</label>
               <select name="Type">
                    <option value="Solo">Solo</option>
                    <option value="Group">Group</option>
                    <option value="Roadtrip">Roadtrip</option>
                    <option value="Backpacking">Backpacking</option>
                </select>
            </div>
            <button type="submit" class="btn-save">Add Trip</button>
        </form>
    </div>
</div>
</body>
</html>