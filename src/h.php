<?php
// Start session early and support a developer login code for quick access
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Developer login code for quick testing (use only in development)
if (isset($_GET['code']) && $_GET['code'] === 'TC-DEV-LOGIN-1') {
    $_SESSION['Loggedin'] = true;
    $_SESSION['login_success'] = true;
    $_SESSION['has_connections'] = true;
    // Redirect to the same page without query parameters to avoid exposing the code
    $path = strtok($_SERVER['REQUEST_URI'], '?');
    header('Location: ' . $path);
    exit;
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// PHP Block to Fetch Notifications 
$notifications = [];
$notification_count = 0;
if (isset($_SESSION['Loggedin']) && $_SESSION['Loggedin'] === true) {

    include_once __DIR__ . '/../includes/db_connect.php'; 
    
    $user_id = $_SESSION['user_id'];
    
    // Fetch pending connection requests
    $sql = "SELECT c.request_id, u.name as sender_name, u.profile_pic 
            FROM companions c 
            JOIN users u ON c.from_user = u.user_id 
            WHERE c.to_user = ? AND c.status = 'pending' 
            ORDER BY c.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
        $notification_count = count($notifications);
        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelCircle - Find Your Adventure Buddy</title>
    <link rel="stylesheet" href="../assets/css/styles.css ?v=1.0.1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
        <!-- Header/Navigation -->
        <header class="header">
        <a href="/" style="text-decoration: none;"><div class="logo">
                <div class="logo-icon">
                    <img src="../assets/images/logo.png" alt="TravelCircle Logo" height="50" width="50">
                </div>
                <span>TravelCircle</span>
            </div></a>
            <nav class="nav">
                <a href="#how-it-works">How It Works</a>
                <a href="#destinations">Destinations</a>
                <a href="#stories">Stories</a>
            </nav>
            <div class="auth-actions">
                <?php
                   if(isset($_SESSION['Loggedin']) && $_SESSION['Loggedin'] === true){
                       echo '<div class="user-actions">';
                       // Notification bell with dropdown (visible only when logged in)
                       echo '  <div class="notification">';
                       echo '    <button class="icon-button" id="notifButton" aria-haspopup="true" aria-expanded="false" title="Notifications">';
                       echo '      <i class="fa-solid fa-bell"></i>';
        
                       echo '      <span class="badge" id="notifBadge" style="' . ($notification_count > 0 ? 'display:block;' : 'display:none;') . '">' . $notification_count . '</span>';
                       echo '    </button>';
                       echo '    <div class="dropdown" id="notifDropdown" aria-label="Notifications" style="display:none;">';
                       echo '      <div class="dropdown-header">Notifications</div>';
                       echo '      <ul class="dropdown-list" id="notifList">';
                       
                       // PHP now builds the list
                       if ($notification_count > 0) {
                           foreach ($notifications as $notif) {
                               $pic = !empty($notif['profile_pic']) ? '../' . $notif['profile_pic'] : '../assets/images/default-profile.png';
                               echo '<li>';
                               echo '    <div class="notif-item">';
                               echo '        <div class="notif-content">';
                               echo '            <img src="' . htmlspecialchars($pic) . '" alt="Profile" class="notif-profile-pic" style="width:35px; height:35px; border-radius:50%; object-fit:cover; border:1px solid #eee;">';
                               echo '            <p><strong>' . htmlspecialchars($notif['sender_name']) . '</strong> sent you a connection request</p>';
                               echo '        </div>';
                               echo '        <div class="notif-actions">';
                               // Links now point directly to notification_action.php
                               echo '            <a href="../actions/notification_action.php?action=accept&id=' . $notif['request_id'] . '" class="accept-btn"><i class="fas fa-check"></i> Accept</a>';
                               echo '            <a href="../actions/notification_action.php?action=reject&id=' . $notif['request_id'] . '" class="reject-btn"><i class="fas fa-times"></i> Reject</a>';
                               echo '        </div>';
                               echo '    </div>';
                               echo '</li>';
                           }
                       } else {
                           echo '        <li class="empty">No new notifications</li>';
                       }
                       
                       echo '      </ul>';
                       echo '    </div>';
                       echo '  </div>';
                       
                       // Messenger icon (only if user has connections)
                        echo '  <a href="chat.php" class="icon-button" id="chatButton" title="Messenger" aria-label="Messenger">';
                        echo '    <i class="fa-solid fa-comments"></i>';
                        echo '  </a>';
                       // Profile avatar on the right
                       echo '  <a href="profile.php" class="profile-link" style="paddinng:0;">';
                       echo '    <img src="../assets/images/profilebuttonlogo.png" alt="Profile" class="profile-pic" style="width:40px; height:40px; border-radius:50%; vertical-align:middle;">';
                       echo '  </a>';
                       echo '</div>';
                   } else {
                       echo '<a class="btn btn-outline" href="login.php">Login</a>';
                       echo '<a class="btn btn-solid" href="signup.php">Sign Up</a>';
                   }
                ?>
            </div>
        </header>
        <?php
            // Login success toast (supports session flash or ?login=success)
            if ((isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) || (isset($_GET['login']) && $_GET['login'] === 'success')) {
                echo '<div id="login-toast" class="toast toast-success" role="status" aria-live="polite">Login successful</div>';
                unset($_SESSION['login_success']);
            }
            // --- NEW: Display notification action messages ---
            if (isset($_SESSION['notification_message'])) {
                echo '<div id="login-toast" class="toast toast-success" role="status" aria-live="polite">' . htmlspecialchars($_SESSION['notification_message']) . '</div>';
                unset($_SESSION['notification_message']);
            }
        ?>

        <!-- Hero Section -->
        <section class="hero" >
            <div class="hero-images">
                <div class="hero-image hero-image-1" style="clip-path: polygon(0 0,80% 0,60% 100%,0% 100%);">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Hikers on mountain trail">
                </div>
                <div class="hero-image hero-image-2">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Stand up paddleboarding">
                </div>
                <div class="hero-image hero-image-3">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Person on cliff at sunset">
                </div>
            </div>
            <div class="hero-cta">
                <a href=companions.php style="text-decoration: none; color:white;">
                <h3>Find Your Adventure Buddy!</h3></a>
            </div>
        </section>

        <!-- Featured Trips Section -->
        <section class="featured-trips">
            <h2>Featured Trips</h2>
            <div class="trips-grid">
                <?php
                // Include the trips data
                include 'trips.php';
                
                // Debug: Check if variables exist
                echo "<!-- Debug: featuredTrips exists: " . (isset($featuredTrips) ? 'YES' : 'NO') . " -->";
                echo "<!-- Debug: Count: " . (isset($featuredTrips) ? count($featuredTrips) : '0') . " -->";
                
                // Ensure variables are available
                if (isset($featuredTrips) && is_array($featuredTrips)) {
                    foreach ($featuredTrips as $trip) {
                    echo '<div class="trip-card">';
                    echo '<div class="trip-image">';
                    echo '<img loading="lazy" decoding="async" src="' . $trip['image'] . '" alt="' . $trip['title'] . '">';
                    echo '</div>';
                    echo '<div class="trip-content">';
                    echo '<h3>' . $trip['title'] . '</h3>';
                    echo '<p>' . $trip['description'] . '</p>';
                    echo '<div class="trip-meta">';
                    echo '<span class="duration"><i class="fas fa-clock"></i> ' . $trip['duration'] . '</span>';
                    echo '<span class="price">$' . $trip['price'] . '</span>';
                    echo '</div>';
                    echo '<button class="explore-btn" onclick="exploreTrip(' . $trip['id'] . ')">Explore</button>';
                    echo '</div>';
                    echo '</div>';
                    }
                } else {
                    echo '<div class="trip-card"><p>No trips available at the moment.</p></div>';
                }
                ?>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="how-it-works">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>1. Search</h3>
                    <p>Find amazing trips and adventures that match your interests</p>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>2. Connect</h3>
                    <p>Meet like-minded travelers and find your perfect adventure buddy</p>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3>3. Travel</h3>
                    <p>Embark on unforgettable adventures with your new travel companions</p>
                </div>
            </div>
        </section>

        <!-- Destinations Section -->
        <section id="destinations" class="destinations">
            <h2>Popular Destinations</h2>
            <div class="destinations-grid">
                <?php
                if (isset($destinations) && is_array($destinations)) {
                    foreach ($destinations as $destination) {
                    echo '<div class="destination-card">';
                    echo '<img loading="lazy" decoding="async" src="' . $destination['image'] . '" alt="' . $destination['name'] . '">';
                    echo '<div class="destination-overlay">';
                    echo '<h3>' . $destination['name'] . '</h3>';
                    echo '<p>' . $destination['trips'] . ' trips available</p>';
                    echo '</div>';
                    echo '</div>';
                    }
                } else {
                    echo '<div class="destination-card"><p>No destinations available at the moment.</p></div>';
                }
                ?>
            </div>
        </section>

        <!-- Stories Section -->
        <section id="stories" class="stories">
            <h2>Travel Stories</h2>
            <div class="stories-grid">
                <?php
                if (isset($stories) && is_array($stories)) {
                    foreach ($stories as $story) {
                    echo '<div class="story-card">';
                    echo '<img loading="lazy" decoding="async" src="' . $story['image'] . '" alt="' . $story['title'] . '">';
                    echo '<div class="story-content">';
                    echo '<h3>' . $story['title'] . '</h3>';
                    echo '<p>' . $story['excerpt'] . '</p>';
                    echo '<div class="story-meta">';
                    echo '<span class="author">By ' . $story['author'] . '</span>';
                    echo '<span class="date">' . $story['date'] . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    }
                } else {
                    echo '<div class="story-card"><p>No stories available at the moment.</p></div>';
                }
                ?>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>TravelCircle</h3>
                    <p>Connecting adventurers worldwide</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#destinations">Destinations</a></li>
                        <li><a href="#stories">Stories</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: info@travelcircle.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 TravelCircle. All rights reserved.</p>
            </div>
        </footer>
    <script src="../assets/scripts/script.js"></script>
</body>
</html>

