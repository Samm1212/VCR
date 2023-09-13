<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit();
}
include '../backend/db_connection.php';

$rName = $_POST['name'];


if (empty($rName)) {
    header ("Location: createRoom.php?error=Please enter a name $rName");
    exit();
}


$sql = "select * from rooms where rName = '$rName';";
$result = $conn->query($sql);
$nRows = mysqli_num_rows($result);
if ($nRows > 0) {
    header ("Location: createRoom.php?error=This room already exists");
    exit();
} else {
    $sql2 = "insert into rooms(rName) values ('$rName');";
    $result2 = $conn->query($sql2);
    header ("Location: createRoom.php?error=Successful!");
    exit();
}
?>