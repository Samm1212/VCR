<?php
session_start();
include 'db_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

if (empty($username)) {
    header ("Location: index.php?error=Please enter your username");
    exit();
} else if (empty($password)) {
    header ("Location: index.php?error=Please enter your password");
    exit();
}


$sql = "select * from users where username = '$username' AND password = '$password' AND role = '$role';";
$result = $conn->query($sql);
$nRows = mysqli_num_rows($result);
if ($nRows > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    header ("Location: home.php");
    exit();
} else {
    header ("Location: index.php?error=Invalid login information.");
    exit();
}
?>