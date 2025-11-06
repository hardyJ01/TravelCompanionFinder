<?php
    include '../actions/profile_action.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Travel Companions</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/companions.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<?php if(isset($_SESSION['success']) || isset($_SESSION['error'])):?>
    <div class="message-container">
        <?php if(isset($_SESSION['success'])):?>
            <div class="message success-message">
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])):?>
            <div class="message error-message">
                <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<body>
    
        <header class="header">
            <div class="logo">
                <div class="logo-icon">
                    <img src="../assets/images/logo.png" alt="TravelCircle Logo" height="50" width="50">
                </div>
                <span> TravelCircle</span>
            </div>
            <nav class="nav">
                <a href="h.php">Home</a>
            </nav>
            <div class="auth-actions">
                <?php
                   if(isset($_SESSION['Loggedin']) && $_SESSION['Loggedin'] === true){
                       echo '<div class="user-actions">';
                       // Notification bell with dropdown (visible only when logged in)
                       echo '  <div class="notification">';
                       echo '    <button class="icon-button" id="notifButton" aria-haspopup="true" aria-expanded="false" title="Notifications">';
                       echo '      <i class="fa-solid fa-bell"></i>';
                       echo '      <span class="badge" id="notifBadge" style="display:none;">0</span>';
                       echo '    </button>';
                       echo '    <div class="dropdown" id="notifDropdown" aria-label="Notifications" style="display:none;">';
                       echo '      <div class="dropdown-header">Notifications</div>';
                       echo '      <ul class="dropdown-list" id="notifList">';
                       echo '        <li class="empty">No new notifications</li>';
                       echo '      </ul>';
                       echo '    </div>';
                       echo '  </div>';
                       // Messenger icon (only if user has connections)
                
                        echo '  <a href="chat.php" class="icon-button" id="chatButton" title="Messenger" aria-label="Messenger">';
                        echo '    <i class="fa-solid fa-comments"></i>';
                        echo '  </a>';
                       // Profile avatar on the right
                       echo '  <a href="profile.php" class="profile-link">';
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

        <section class="companion-search">
            <div class="search-row">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input id="searchText" type="text" placeholder="Search destination, language, preferences...">
                </div>
                <div class="filters">
                    <select id="typeFilter">
                        <option value="">All Types</option>
                        <option value="Solo">Solo</option>
                        <option value="Group">Group</option>
                        <option value="Roadtrip">Roadtrip</option>
                        <option value="Backpacking">Backpacking</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="companions-list" id="companionsList">
            <!-- Cards will be injected by JS -->
        </section>

        <footer class="footer">
            <div class="footer-bottom">
                <p>&copy; 2024 TravelCircle. All rights reserved.</p>
            </div>
        </footer>
    
    <?php


$companions = array();
if ($active_trips_companions && $active_trips_companions->num_rows > 0) {

    while ($row = $active_trips_companions->fetch_assoc()) {
        $companions[] = [
            'id' => $row['user_id'],
            'name' => $row['name'],
            'photo' => !empty($row['profile_pic']) ? '../' . $row['profile_pic'] : '../assets/images/default-profile.png',
            'destination' => $row['destination'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'budget' => $row['budget'],
            'language' => $row['language'],
            'type' => $row['type'],
            'preferences' => $row['preferences']
        ];
    }
}
?>
<script>
    const companions = <?php echo json_encode($companions ?? []); ?>;

    function formatCurrency(v) {
        return '₹' + Number(v).toLocaleString(undefined, {minimumFractionDigits: 2});
    }

    function renderCards(list) {
        const wrap = document.getElementById('companionsList');
        wrap.innerHTML = '';
        if (list.length === 0) {
            wrap.innerHTML = '<p style="text-align:center;color:#666;margin-top:2rem;">No matching companions found.</p>';
            return;
        }

        list.forEach(c => {
            const card = document.createElement('div');
            card.className = 'companion-card';
            card.innerHTML = `
                <div class="card-left">
                    <img src="${c.photo}" alt="${c.name}" loading="lazy" decoding="async">
                </div>
                <div class="card-right">
                    <div class="card-head">
                        <h2>${c.name}</h2>
                        <h5>${c.type}</h5>
                    </div>
                    <div class="card-dest">
                        <h3>Destination</h3>
                        <h4>${c.destination}</h4>
                    </div>
                    <div class="card-grid">
                        <div><label>Start</label><strong>${c.start_date}</strong></div>
                        <div><label>End</label><strong>${c.end_date}</strong></div>
                        <div><label>Budget</label><strong>${formatCurrency(c.budget)}</strong></div>
                        <div><label>Language</label><strong>${c.language}</strong></div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; color: var(--ebony); opacity: .8;">Preferences</label>
                    </div>
                    <h5 class="prefs" style="display: block; color: var(--black-olive);">${c.preferences}</h5>
                    <form action="../actions/connection_action.php" method="POST" class="connect-form">
                        <input type="hidden" name="receiver_id" value="${c.id}">
                        <button class="connect-btn" type="submit">
                        <i class="fas fa-paper-plane"></i> Connect
                        </button>
                    </form>
                </div>`;
            wrap.appendChild(card);
        });
    }

    function applyFilters() {
        const q = document.getElementById('searchText').value.toLowerCase();
        const t = document.getElementById('typeFilter').value;
        const filtered = companions.filter(c => {
            const matchesText = [c.destination, c.name, c.language, c.preferences].join(' ').toLowerCase().includes(q);
            const matchesType = !t || c.type === t;
            return matchesText && matchesType;
        });
        renderCards(filtered);
    }

    document.getElementById('searchText').addEventListener('input', applyFilters);
    document.getElementById('typeFilter').addEventListener('change', applyFilters);

    // Replace the commented out click listener with this:
    document.addEventListener('submit', async (e) => {
        if (!e.target.matches('.connect-form')) return;
        const button = e.target.querySelector('.connect-btn');
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
});

    renderCards(companions);
</script>

</body>
</html>