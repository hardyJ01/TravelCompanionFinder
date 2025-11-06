<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../actions/chat_action.php");

// Guard: logged in and has connections
if (!isset($_SESSION['Loggedin']) || $_SESSION['Loggedin'] !== true) {
    header('h.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger - TravelCircle</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <a href="h.php" style="text-decoration:none;"><div class="logo"><div class="logo-icon"><img src="../assets/images/logo.png" alt="TravelCircle Logo" height="40" width="40"></div><span>TravelCircle</span></div></a>
        <div class="auth-actions">
            <a href="h.php" class="btn btn-outline">Home</a>
        </div>
    </header>

    <main class="chat">
        <aside class="chat-sidebar">
            <div class="chat-sidebar-header">Messages</div>
            <ul class="chat-user-list" id="chatUserList">
             <?php if(!empty($connectedUsers)): ?>
                <?php foreach ($connectedUsers as $u): ?>
                    <?php
                        $user_id=0;
                        if($u['user_id']===$_SESSION['user_id']){
                            $user_id=$u['user_id'];
                        }
                        else{
                            $user_id=$u['user_id'];
                        }
                        $userName = isset($u['sender_name']) ? htmlspecialchars($u['sender_name']) : 'Unknown';
                        $firstLetter = !empty($userName) ? strtoupper(substr($userName,0,1)) : '?';
                    ?>
                    <li class="chat-user" data-user-id="<?php echo $user_id; ?>" data-user-name="<?php echo $userName; ?>">
                        <div class="avatar-circle"><?php echo $firstLetter; ?></div>
                        <span><?php echo $userName; ?></span>
                    </li>
                <?php endforeach; ?>
                <?php else : ?>
                    <li class="no-connection"> No Connections yet </li>
                <?php endif; ?>
            </ul>
        </aside>
        <section class="chat-window">
            <div class="chat-header" id="chatHeader">Select a connection to start chatting</div>
            <div class="chat-messages" id="chatMessages"></div>
            <form class="chat-input" id="chatForm">
                <input type="text" id="chatText" placeholder="Type a message..." autocomplete="off" />
                <button type="submit" class="btn btn-solid"><i class="fas fa-paper-plane"></i></button>
            </form>
        </section>
    </main>
<script>
(function(){
    const userList = document.getElementById('chatUserList');
    const messagesEl = document.getElementById('chatMessages');
    const headerEl = document.getElementById('chatHeader');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('chatText');

    let activeUserId = null;
    let activeUserName = '';

    // Function to load chat history
    async function loadChatHistory(userId) {
        try {
            const response = await fetch('../actions/message_action.php?v=1.0.1', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'get_messages',
                    to_user: userId
                })
            });
            const data = await response.json();
            if (data.success) {
                renderMessages(data.messages);
            } else {
                console.error('Failed to load messages:', data.message);
            }
        } catch (error) {
            console.error('Error loading messages:', error);
        }
    }

    // Function to render messages
    function renderMessages(messages) {
        messagesEl.innerHTML = '';
        messages.forEach(msg => {
            const bubble = document.createElement('div');
            bubble.className = 'chat-bubble ' + (msg.from_me ? 'me' : 'them');
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.textContent = msg.content;

            const timestamp = document.createElement('div');
            timestamp.className = 'message-time';
            timestamp.textContent = new Date(msg.created_at).toLocaleTimeString();

            bubble.appendChild(messageContent);
            bubble.appendChild(timestamp);
            messagesEl.appendChild(bubble);
        });
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    // Handle user selection
    userList.addEventListener('click', async (e) => {
        const item = e.target.closest('.chat-user');
        if (!item) return;
        
        document.querySelectorAll('.chat-user.active')
            .forEach(li => li.classList.remove('active'));
        
        item.classList.add('active');
        activeUserId = item.getAttribute('data-user-id');
        activeUserName = item.getAttribute('data-user-name');
        headerEl.textContent = 'Chat with ' + activeUserName;
        
        await loadChatHistory(activeUserId);
    });

    // Handle message submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text || !activeUserId) return;

        try {
            const response = await fetch('../actions/message_action.php?v=1.0.1', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'send_message',
                    to_user: activeUserId,
                    content: text
                })
            });

            const data = await response.json();
            if (data.success) {
                input.value = '';
                await loadChatHistory(activeUserId);
            } else {
                alert('Failed to send message: ' + data.message);
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        }
    });

    // Auto refresh messages every 5 seconds for active chat
    setInterval(() => {
        if (activeUserId) {
            loadChatHistory(activeUserId);
        }
    }, 5000);
})();
</script>
</body>
</html>


