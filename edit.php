<?php
session_start();
$url="localhost";
$usr="root";
$pass="";
$dbs="project";
$port=3307;
$conn=new mysqli($url,$usr,$pass,$dbs,$port);

if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}
$uid=1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tripid = intval($_GET["trip_id"]);
    $from = $_POST["from"];
    $destination = $_POST["destination"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $budget = $_POST["budget"];
    $type = $_POST["type"];
    $preference = $_POST["preference"];

    $update_sql = "UPDATE trips 
                   SET from_location=?, destination=?, start_date=?, end_date=?, budget=?, type=?, preference=? 
                   WHERE trip_id=? AND user_id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssissii", $from, $destination, $start_date, $end_date, $budget, $type, $preference, $tripid, $uid);

    if ($update_stmt->execute()) {
        echo "<h3 style='text-align: center; color: green; margin-top: 50px;'>Trip updated successfully!!</h3>";
        echo '<p style="text-align:center; margin-top:20px;"><a href="mytrips.php" style="color:#007BFF;">&larr; Back to My Trips</a></p>';
    } else {
        echo "<script>alert('Failed to update trip.');</script>";
    }
    $update_stmt->close();
}

$tripid = intval($_GET["trip_id"] ?? 0);
$sql = "SELECT * FROM trips WHERE trip_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $tripid, $uid);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Trip</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #e0f7fa, #fffde7);
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input, select, button {
      width: 100%;
      padding: 8px 10px;
      margin-top: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    button {
      margin-top: 20px;
      background-color: turquoise;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: cyan;
      color: coral;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 style="color: coral;">Edit Trip</h2>
  <form id="editTripForm" action="edit.php?trip_id=<?= $tripid ?>" method="post">
    
    <label for="from">From:</label>
    <input type="text" id="from" name="from" value="<?= htmlspecialchars($row['from_location']) ?>" required>

    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" value="<?= htmlspecialchars($row['destination']) ?>" required>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($row['start_date']) ?>" required>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($row['end_date']) ?>" required>

    <label for="budget">Budget:</label>
    <input type="number" id="budget" name="budget" min="0" value="<?= htmlspecialchars($row['budget']) ?>" required>

    <label for="type">Trip Type:</label>
    <select id="type" name="type" required>
      <option value="">Select trip type</option>
      <option value="Adventure" <?= ($row['type'] ?? '') == 'Adventure' ? 'selected' : '' ?>>Adventure</option>
      <option value="Leisure" <?= ($row['type'] ?? '') == 'Leisure' ? 'selected' : '' ?>>Leisure</option>
      <option value="Business" <?= ($row['type'] ?? '') == 'Business' ? 'selected' : '' ?>>Business</option>
      <option value="Cultural" <?= ($row['type'] ?? '') == 'Cultural' ? 'selected' : '' ?>>Cultural</option>
    </select>
    
    <label for="preference">Gender preference: </label>
    <select id="preference" name="preference" required>
      <option value="">Select Gender preference</option>
      <option value="Any" <?= ($row['preference'] ?? '') == 'Any' ? 'selected' : '' ?>>Any</option>
      <option value="Male" <?= ($row['preference'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= ($row['preference'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
    </select>

    <button type="submit">Update Trip</button>
  </form>
</div>

</body>
</html>
