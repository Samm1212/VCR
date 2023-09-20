<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit();
}
include 'db_connection.php';

$onlineUsers = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['roomName'])) {
    $roomName = $_GET['roomName'];
    $sql = "select * from users where room = '$roomName';";
    $res = $conn->query($sql);
    $nRows = mysqli_num_rows($res);
    
    while ($row = mysqli_fetch_assoc($res)) {
        $un = $row['username'];
        array_push($onlineUsers, $un);
    }

    header('Content-type: application/json');
    echo json_encode($onlineUsers);
} else {
    header('Content-type: application/json');
    echo json_encode([]);
}
?>
