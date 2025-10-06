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
$uid=$_SESSION["user_id"]??1;
$sql="select * from trips where user_id=$uid order by start_date asc";
$res=$conn->query($sql);

if (!$res) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Trips</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #e0f7fa, #fffde7);
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 900px;
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
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #f0f0f0;
    }
    a, button {
      padding: 5px 10px;
      margin: 2px;
      border-radius: 4px;
      text-decoration: none;
      cursor: pointer;
    }
    .edit { background-color: orange; color: white; border: none; }
    .delete { background-color: #dc3545; color: white; border: none; }
    .view {background-color: #51d093ff; color: white; border: none;}
    .create {
      display: inline-block;
      margin-bottom: 15px;
      padding: 8px 15px;
      background-color: turquoise;
      color: white;
      font-weight: bold;
      border-radius: 4px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 style="color: coral;">My Trips</h2>
  <a href="create.php" class="create">Create New Trip</a>

  <?php if($res->num_rows > 0):?>
    <table>
      <tr>
        <th>Trip ID</th>
        <th>From</th>
        <th>Destination</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Budget(₹)</th>
        <th>Type</th>
        <th>Actions</th>
      </tr>
      <?php while($row=$res->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row["trip_id"])?></td>
        <td><?= htmlspecialchars($row["from_location"])?></td>
        <td><?= htmlspecialchars($row["destination"])?></td>
        <td><?= htmlspecialchars($row["start_date"])?></td>
        <td><?= htmlspecialchars($row["end_date"])?></td>
        <td><?= htmlspecialchars($row["budget"])?></td>
        <td><?= htmlspecialchars($row["type"])?></td>
        <td>
          <button class="view" onclick="window.location.href='viewtrip.php?id=<?= $row['trip_id'] ?>'">View</button>
          <button class="edit" onclick="editTrip( <?= htmlspecialchars($row["trip_id"])?> )">Edit</button>
          <button class="delete" onclick="deleteTrip(<?= htmlspecialchars($row["trip_id"])?>)">Delete</button>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
    <?php else: ?>
      <p>No trips found.</p>
  <?php endif; ?>
</div>

<script>
  function editTrip(tripId) {
    window.location.href = "edit.php?trip_id=" + tripId;
  }

  function deleteTrip(tripId) {
    const confirmDelete = confirm("Are you sure you want to delete this trip?");
    if (confirmDelete) {
      fetch("delete.php?id="+tripId)
      .then(response=>response.text())
      .then(data=>{
        if(data==="success"){
          alert("Trip deleted successfully")
          location.reload();
        }
        else{
          alert("Failed to delete. Please try again")
        }
      });
    }
  }
</script>

</body>
</html>
