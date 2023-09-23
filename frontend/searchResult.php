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
    
    <div class="container-fluid p-4">
        <h3>Search Result</h3>
        <?php
        include '../backend/db_connection.php';
        $rName = $_POST['roomName'];
        $st = $_POST['searchTerm'];
        $sql = "select * from messages where content LIKE'%$st%';";
        $res = $conn->query($sql);
        $nRows = mysqli_num_rows($res);
        if ($nRows < 1) {
            echo '<p>No result was found.</p>';
        } else {
            $n = 0;
            echo "<table class='table'>
            <tr><th>Sender</th><th>Message</th><th>Timestamp</th></tr>";
            while ($n < $nRows) {
                $row = mysqli_fetch_assoc($res);
                $sender = $row['sender'];
                $message = $row['content'];
                $dt = $row['dt'];
                echo "<tr><td>$sender</td><td>$message</td><td>$dt</td></tr>";
                $n = $n + 1;
            }
            echo "</table>";
        }
        ?>
    </div>
</body>
</html>
<?php } else {
    header("location: index.php");
}
?>
