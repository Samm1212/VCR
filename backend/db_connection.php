<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$sname = "localhost";
$uname = "root";
$pass = "rootPass";
$db = "vcr";
$conn = mysqli_connect($sname, $uname, $pass, $db);

if (!$conn) {
    echo "Connection failed!";
}
?>