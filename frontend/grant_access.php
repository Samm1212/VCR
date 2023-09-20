<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit();
}
include '../backend/db_connection.php';

$roomName = $_POST['roomName'];
$username = $_POST['username'];

$sql = "select * from rooms where rName = '$roomName' AND allowedUNs LIKE '%$username%';";
$res = $conn->query($sql);
$nRows = mysqli_num_rows($res);
if ($nRows > 0) {
    header ("Location: manageAccesses.php?error=Access is already granted");
    exit();
} else {
    $sql2 = "select * from rooms where rName = '$roomName';";
    $res2 = $conn->query($sql2);
    $row = mysqli_fetch_assoc($res2);
    $allowed = $row['allowedUNs'];
    $allowed = $allowed . ";;$username";
    $sql3 = "update rooms set allowedUNs = '$allowed' where rName = '$roomName';";
    $res3 = $conn->query($sql3);
    header ("Location: manageAccesses.php?error=Access granted!");
    exit();
}
?>