<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelCircle - Find Your Adventure Buddy</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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
                   session_start();
                   if(isset($_SESSION['Loggedin']) && $_SESSION['Loggedin'] === true){
                    //    echo '<a class="btn btn-outline" href="profile.php">Profile</a>';
                        echo '<a href="profile.php" class="profile-link">
                        <img src="../assets/images/profilebuttonlogo.png" alt="Profile" class="profile-pic" style="width:50px; height:50px; border-radius:50%; vertical-align:middle; margin-right:8px;">
                        </a>';
                    
                   } else {
                       echo '<a class="btn btn-outline" href="login.php">Login</a>';
                       echo '<a class="btn btn-solid" href="signup.php">Sign Up</a>';
                   }
                ?>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-images">
                <div class="hero-image hero-image-1">
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
                <h3>Find Your Adventure Buddy!</h3>
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
    <script src="script.js"></script>
</body>
</html>

