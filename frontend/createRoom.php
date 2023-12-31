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
    <div class="p-2"></div>
    <div class="container-fluid border rounded border-dark d-flex justify-content-center pt-4 pb-4" style="width: fit-content; background-color:honeydew; padding: 0.3em;">
        <div style="width:auto; margin: 0.5em;">
        <form action="create_room.php" method="post">
            <h2 style="width: fit-content; background-color:honeydew; padding: 0.3em;">Create Room</h2>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label style="width: fit-content; background-color:honeydew; padding: 0.3em;" for="name">Name:</label><br><br>
            <input type="text" name="name" maxlength="20" id="name"><br><br>
            <input type="submit" value="Create">
            </div>
        </form>
        </div>
    </div>
</body>
</html>
<?php } else {
    header("location: index.php");
}
?>
