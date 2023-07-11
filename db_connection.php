<?php
$sname = "localhost";
$uname = "root";
$pass = "rootPass";
$db = "vcr";
$conn = mysqli_connect($sname, $uname, $pass, $db);

if (!$conn) {
    echo "Connection failed!";
}
?>