<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Travel Circle</title>
    <link href="../assets/css/login.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="login-card">
        <div class="login-form">
            <div class="form-header">
                <h3>Login</h3>
                <p>Welcome back! Let the next adventure begin.</p>
                <?php
                session_start();
                if(isset($_SESSION['login_error'])) {
                    echo '<div id="error-message">'.$_SESSION['login_error'].'</div>';
                    unset($_SESSION['login_error']);
                }
                ?>
            </div>
        <form action="../actions/login_action.php" method="POST">
            <div class="form-group">
            Email<br> <input type="email" name="email" required><br><br>
            </div>
            <div class="form-group">
            Password<br> <input type="password" name="password" required><br><br>
            </div>
            <button type="submit" class="btn" >Login</button>
        </form>
        <div class="signup-link">
         <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
        </div>

        <div class="login-theme-block">
            <div class="overlay"></div>
            <div class="theme-content">
                <h4>Your next journey awaits.</h4>
                <p>"The word is a book and those who do not travel read only one page."</p>
            </div>
        </div>
    </div>
    
</div>
</body>
</html>