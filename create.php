<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $server="localhost";
    $usr="root";
    $pass="";
    $dbs="project";
    $port=3307;

    $conn=new mysqli($server,$usr,$pass,$dbs,$port);
    if($conn->connect_error){
        die("Connection failed".$conn->connect_error);
    }

    $from=$_POST["from"];
    $dest=$_POST["destination"];
    $start=$_POST["start_date"];
    $end=$_POST["end_date"];
    $budget=$_POST["budget"];
    $type=$_POST["type"];
    $preference=$_POST["preference"];

    $sql="INSERT INTO `trips`(`user_id`, `from_location`, `destination`, `start_date`, `end_date`, `budget`, `type`, `preference`,`created_at`) VALUES (1,'$from','$dest','$start','$end','$budget','$type','$preference',current_timestamp())";

    if($conn->query($sql)){
        echo "<h3 style='text-align: center; color: green; margin-top: 50px;'>New trip created successfully!!</h3>";
        echo '<p style="text-align:center; margin-top:20px;"><a href="mytrips.php" style="color:#007BFF;">&larr; Back to My Trips</a></p>';
    }
    else{
        echo "error: ".$conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Trip</title>
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
      font-weight: bold;
      font-size: medium;
      margin-top: 20px;
      background-color: turquoise;
      color: white;
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
  <h2 style="color: coral;">Create Trip</h2>
  <form id="tripForm" action="create.php" method="POST">

    <label for="from">From:</label>
    <input type="text" id="from" name="from" placeholder="Enter starting point" required>

    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" placeholder="Enter destination" required>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required>

    <label for="budget">Budget:</label>
    <input type="number" id="budget" name="budget" placeholder="Enter budget" min="0" required>

    <label for="type">Trip Type:</label>
    <select id="type" name="type" required>
      <option value="">Select trip type</option>
      <option value="Adventure">Adventure</option>
      <option value="Leisure">Leisure</option>
      <option value="Business">Business</option>
      <option value="Cultural">Cultural</option>
    </select>

    <label for="preference">Gender preference: </label>
    <select id="preference" name="preference" required>
      <option value="">Select Gender preference</option>
      <option value="Any">Any</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>

    <button type="submit">Create Trip</button>
  </form>
</div>

<script>
  document.getElementById("tripForm").addEventListener("submit", function(e) {
     const start = document.getElementById("start_date").value;
    const end = document.getElementById("end_date").value;

    if (end < start) {
        e.preventDefault();
        alert("End date cannot be before start date.");
    }
  });
</script>

</body>
</html>
