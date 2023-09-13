<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Room</title>
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
                    <a class="nav-link" href="createRoom.php">Create Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deleteRoom.php">Delete Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container-fluid">
        <h3>Room List</h3>
        <table class="table">
            <th>Room Name</th><th></th>
            <?php
            include '../backend/db_connection.php';
            $sql = "select * from rooms;";
            $res = $conn->query($sql);
            $nRows = mysqli_num_rows($res);
            $n = 0;
            while ($n < $nRows) {
                $room = mysqli_fetch_assoc($res);
                $rName = $room['rName'];
                echo "<tr><td>$rName</td><td><button class=\"btn_delete\" id=\"$rName\">Delete</button></tr>";
                $n++;
            }
            ?>
        </table>
    </div>
    <script>
        const delete_btns = document.getElementsByClassName("btn_delete");
        var rName;

        const deleted = e => {
            rName = e.target.id;
            requestAjax();
        }

        for (let btn of delete_btns) {
            btn.addEventListener("click", deleted);
        }

        function requestAjax() {
            $.ajax({
                url: 'delete_room.php',
                method: 'POST',
                data: {rName: rName},
                success: function(response) {
                    console.log(response);
                    location.reload();
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
