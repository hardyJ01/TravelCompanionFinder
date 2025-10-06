<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db = "project";
$port = 3307;

$conn = new mysqli($server, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$trip_id = $_GET['id'] ?? 0;
$uid = 1;

$sql_trip = "SELECT * FROM trips WHERE trip_id = $trip_id AND user_id = $uid";
$res_trip = $conn->query($sql_trip);
if (!$res_trip || $res_trip->num_rows == 0) {
    die("Trip not found or you do not have access.");
}

$trip = $res_trip->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Trip</title>
  <style>
    body { 
        font-family: Arial; 
        background: linear-gradient(135deg, #e0f7fa, #fffde7);
        margin: 0; 
        padding: 0; }
    .container { 
        max-width: 700px; 
        margin: 50px auto; 
        background: white; 
        padding: 20px 30px; 
        border-radius: 8px; 
        box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { 
        text-align: center; 
        margin-bottom: 20px; }
    .detail { margin: 15px 0; }
    .label { 
        font-weight: bold; 
        display: inline-block; 
        width: 150px; }
    a.back { 
        display: inline-block; 
        margin-left: 40%;
        padding: 8px 15px; 
        background-color: turquoise; 
        color: white; 
        font-weight: bold;
        border-radius: 4px; 
        text-decoration: none; }
  </style>
</head>
<body>
<div class="container">
  <h2 style="color: coral;">Trip Details</h2>

  <div class="detail"><span class="label">From:</span> <?= htmlspecialchars($trip['from_location']) ?></div>
  <div class="detail"><span class="label">Destination:</span> <?= htmlspecialchars($trip['destination']) ?></div>
  <div class="detail"><span class="label">Start Date:</span> <?= htmlspecialchars($trip['start_date']) ?></div>
  <div class="detail"><span class="label">End Date:</span> <?= htmlspecialchars($trip['end_date']) ?></div>
  <div class="detail"><span class="label">Budget:</span> ₹<?= htmlspecialchars($trip['budget']) ?></div>
  <div class="detail"><span class="label">Type:</span> <?= htmlspecialchars($trip['type']) ?></div>
  <div class="detail"><span class="label">Gender preference:</span> <?= htmlspecialchars($trip['preference']) ?></div>

  <a class="back" href="mytrips.php">Back to My Trips</a>
</div>
</body>
</html>

<?php $conn->close(); ?>
