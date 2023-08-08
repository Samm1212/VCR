<?php
session_start();
if (isset($_SESSION['username'])) { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php $username = $_SESSION['username']; echo "<p class=\"nav-link\">$username</p>"; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="chat-app">
        <h1>Welcome to the Chat Room</h1>

        <!-- Room selection -->
        <div>
            <label for="room">Select a Room:</label>
            <select id="room" name="room"></select>
        </div>

        <!-- Chat messages display -->
        <div id="chat-messages"></div>

        <!-- Message input and send button -->
        <form id="message-form">
            <input type="text" id="message-input" name="message" required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.3/socket.io.js"></script>
    <script src="VirtualChatRoom.js"></script>
</body>
</html>
<?php } else {
    header("location: index.php");
}
?>
