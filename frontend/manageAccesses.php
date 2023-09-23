<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manage Accesses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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
                    <a class="nav-link" href="search.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="createRoom.php">Create Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deleteRoom.php">Delete Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manageAccesses.php">Manage Accesses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <h3>Manage Accesses</h3>
        <div class="container-fluid border border-dark d-flex justify-content-center pt-4 pb-4" style="width: fit-content;">
        <div style="width: 200px;">
        <form action="create_room.php" method="post">
            <h2>Give/Remove Access</h2>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label for="roomName">Room Name:</label><br>
            <select id="roomName" name="roomName">
                <?php
                include '../backend/db_connection.php';
                $sql = "select * from rooms";
                $res = $conn->query($sql);
                $nRows = mysqli_num_rows($res);
                $n = 0;
                while ($n < $nRows) {
                    $row = mysqli_fetch_assoc($res);
                    $rName = $row['rName'];
                    echo "<option value='$rName'>$rName</option>";
                    $n = $n + 1;
                }
                ?>
            </select><br><br>
            <label for="username">Username:</label><br>
            <select id="username" name="username">
                <?php
                include '../backend/db_connection.php';
                $sql = "select * from users";
                $res = $conn->query($sql);
                $nRows = mysqli_num_rows($res);
                $n = 0;
                while ($n < $nRows) {
                    $row = mysqli_fetch_assoc($res);
                    $un = $row['username'];
                    echo "<option value='$un'>$un</option>";
                    $n = $n + 1;
                }
                ?>
            </select><br><br>
            <input type="button" id="btn_add" value="Add">&nbsp;&nbsp;
            <input type="button" id="btn_remove" value="Remove">
            </div>
        </form>
        </div>
        <p id="message"></p>
    </div>
    </div>
    <script>
        const btn_add = document.getElementById('btn_add');
        const btn_remove = document.getElementById('btn_remove');
        const roomSelect = document.getElementById('roomName');
        const unSelect = document.getElementById('username');
        const message = document.getElementById('message');

        var roomName = "";
        var username = "";

        const addClicked = e => {
            roomName = roomSelect.value;
            username = unSelect.value;
            addAjax();
        }

        const removeClicked = e => {
            roomName = roomSelect.value;
            username = unSelect.value;
            removeAjax();
        }

        btn_add.addEventListener('click', addClicked);
        btn_remove.addEventListener('click', removeClicked);

        function addAjax() {
            $.ajax({
                url: 'grant_access.php',
                method: 'POST',
                data: {roomName: roomName, username: username},
                success: function(response) {
                    console.log('success!');
                    message.textContent = "Access is granted!";
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function removeAjax() {
            $.ajax({
                url: 'remove_Access.php',
                method: 'POST',
                data: {roomName: roomName, username: username},
                success: function(response) {
                    console.log('success!');
                    message.textContent = "Access is removed!";
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    </script>
</body>
</html>
<?php } else {
    header("location: index.php");
}
?>
