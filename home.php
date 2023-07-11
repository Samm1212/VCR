<?php
session_start();
if (isset($_SESSION['username'])) { ?>
<p>work in progress</p>
<a href="logout.php">Logout</a>
<?php } else {
    header ("location: index.php");
}
?>
