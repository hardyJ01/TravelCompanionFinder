<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Travel Companion</title>
    <link rel="stylesheet" href="../assets/css/signup.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="signup-container">
        <div class="signup-card">
            <!-- Left Side: The Form -->
            <div class="signup-form">
                <div class="form-header">
                    <h3>Create Account</h3>
                    <p>Join our community of travelers!</p>
                    <p>Fill out the form below to get started.</p>
                    <?php
                    session_start();
                    if(isset($_SESSION['signup_error'])) {
                        echo '<div id="error-message">' . htmlspecialchars($_SESSION['signup_error']) . '</div>';
                        unset($_SESSION['signup_error']);
                    }
                    if(isset($_SESSION['signup_success'])) {
                        echo '<div id="success-message">' . htmlspecialchars($_SESSION['signup_success']) .
                            '<a href="login.php">Click here to Login</a></div>';
                        unset($_SESSION['signup_success']);
                    }
                    ?>  
                </div>
                <!-- Make sure to update the action attribute to your signup script -->
                <form action="../actions/signup_action.php" method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn">Sign Up</button>
                    </div>
                </form>
                 <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
            </div>

            <!-- Right Side: Thematic Block -->
            <div class="signup-theme-block">
                <div class="theme-content">
                    <h4>A journey of a thousand miles begins with a single step.</h4>
                    <p class="quote">"The world is a book and those who do not travel read only one page."</p>
                    <p class="author">- Saint Augustine</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
