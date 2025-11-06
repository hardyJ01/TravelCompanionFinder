<?php
require_once '../actions/profile_action.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link href="../assets/css/profile.css?v=1.1" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card_text-center">
                <?php
                $default_pic = '../assets/images/default-profile.png'; 
                $profile_pic = !empty($user['profile_pic']) ?'../'.$user['profile_pic']: $default_pic;
                ?>  
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" class="card-img-top rounded-circle p-3" 
                alt ="Profile Picture" style="width: 150px; height: 150px; object-fit: cover; margin: auto;">
                <div class="card-body">
                    <h4><?php echo $user['name']; ?></h4>
                    <p><?php echo $user['bio']; ?></p>
                    <p><?php echo $user['location']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Profile Information</div>
                <div class="card-body">
                    <p><b>Full Name:</b> <?php echo $user['name']; ?></p>
                    <p><b>Email:</b> <?php echo $user['email']; ?></p>
                    <p><b>Language:</b> <?php echo $user['language']; ?></p>
                    <p><b>Age:</b> <?php echo $user['age']; ?></p>
                    <p><b>Gender:</b> <?php echo $user['gender']; ?></p>
                    <p><b>Preferences:</b> <?php echo $user['preferences']; ?></p>
                    <a href="editprofile.php" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">My Trips</div>
                <div class="card-body">

                    <h3 class="trips-section-title"> 🟢 Active Trips </h3>
                    <div class="trip-list">
                        <?php 
                        // Loop through $active_trips
                        if (isset($active_trips) && $active_trips->num_rows > 0) {
                            while ($trip = $active_trips->fetch_assoc()) { 
                        ?>
                            <p class="trip-item"><b><?php echo htmlspecialchars($trip['destination']); ?></b> (<?php echo htmlspecialchars($trip['start_date']); ?> to <?php echo htmlspecialchars($trip['end_date']); ?>)</p>
                        <?php 
                            }
                            $active_trips->free(); // Free the result
                        } else { 
                        ?>
                            <p>No active trips planned!</p>
                        <?php } ?>
                    </div>
                    
                    <hr class="trip-divider">
                    
                    <h3 class="trips-section-title">🔴 Completed Trips</h3>
                    <div class="trip-list">
                        <?php 
                        // Loop through $completed_trips
                        if (isset($completed_trips) && $completed_trips->num_rows > 0) {
                            while ($trip = $completed_trips->fetch_assoc()) { 
                        ?>
                            <p class="trip-item completed"><b><?php echo htmlspecialchars($trip['destination']); ?></b> (<?php echo htmlspecialchars($trip['start_date']); ?> - <?php echo htmlspecialchars($trip['end_date']); ?>)</p>
                        <?php 
                            }
                            $completed_trips->free(); // Free the result
                        } else { 
                        ?>
                            <p>No completed trips yet.</p>
                        <?php } ?>
                    </div>

                </div>
                <a href="addtrip.php" class="btn btn-primary m-3" style="margin:10px 10px 10px 10px;">Add New Trip</a>
            </div>
            <div class="card">
                <div class="card-header">Reviews</div>
                <div class="card-body">
                    <?php while ($review = $reviews->fetch_assoc()) { ?>
                        <p><b><?php echo $review['reviewer_name']; ?>:</b> <?php echo $review['comment']; ?> (⭐ <?php echo $review['rating']; ?>/5)</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
