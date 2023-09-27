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
<body style="background-color: #89CFF0;">
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
                    <a class="nav-link" href="search.php">Search</a>
                </li>
                <?php
                if ($_SESSION['role'] == 'admin') {
                    echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"createRoom.php\">Create Room</a>
                </li>";
                    echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"deleteRoom.php\">Delete Room</a>
                </li>";
                    echo "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"manageAccesses.php\">Manage Accesses</a>
                </li>";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid pt-2" id="chat-app" style="background-color: #89CFF0;">
        <h1 style="width: fit-content; background-color:honeydew; padding: 0.3em;">Welcome to the Chat Room</h1>

        <!-- Room selection -->
        <div class="container-fluid pt-2 pb-2">
            <label style="width: fit-content; background-color:honeydew; padding: 0.3em;" for="room" class="form-label">Select a Room:</label>
            <select id="room" name="room" class="form-select">
                <option value="" selected disabled></option>
            </select>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    console.log("Script started");
                    fetch('../backend/api.php')
                        .then(response => response.json())
                        .then(rooms => {
                            const selectElement = document.getElementById('room');
                            rooms.forEach(room => {
                                const option = document.createElement('option');
                                option.value = room.rName;
                                option.text = room.rName;
                                selectElement.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching rooms:', error));
                });
            </script>

        </div>

        <div id="online-users" class="container m-4">
            <h3 style="width: fit-content; background-color:honeydew; padding: 0.3em;">Online Users</h3>
            <ul id="user-list" class="list-group"></ul>
        </div>

        <!-- Chat messages display -->
        <div class="container-fluid pt-2 border rounded border-2" id="chat-messages" style="height: 300px; overflow-y: auto;"></div>

        <!-- Message input and send button -->
        <form class="form m-3 p-3" id="message-form">
            <div class="input-group">
                <input type="text" id="message-input" name="message" required>
                <button type="submit">Send</button>
            </div>
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
