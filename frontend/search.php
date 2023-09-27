<?php
session_start();
if (isset($_SESSION['username'])) { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Search</title>
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
    <div class="container-fluid pt-3" style="background-color: #89CFF0;">
        <h3 style="width: fit-content; background-color:honeydew; padding: 0.5em;">Search Chat History</h3>
        <div class="container-fluid border rounded border-dark d-flex justify-content-center pt-4 pb-4" style="width: fit-content; background-color:honeydew;">
        <div style="width: 200px;">
        <form action="searchResult.php" method="post" style="padding: 0.5em;">
            <h2>Search</h2>
            <label for="roomName">Room Name:</label><br>
            <select id="roomName" name="roomName">
                <?php
                include '../backend/db_connection.php';
                session_start();
                $un = $_SESSION['username'];
                $sql = "select * from rooms where allowedUNs LIKE '%$un%';";
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
            <label for="searchTerm">Search for:</label><br>
            <input type="text" name="searchTerm" id="searchTerm" maxlength="50"><br><br>
            <button type="submit" id="submit">Search</button>
            </div>
        </form>
        </div>
    </div>
    <script>
        const st = document.getElementById('searchTerm');
        const btn_submit = document.getElementById('submit');

        btn_submit.addEventListener('click', function(event) {
            var input = st.value;
            if (!input) {
                st.placeholder = 'Enter a search term!';
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
<?php } else {
    header("location: index.php");
}
?>
