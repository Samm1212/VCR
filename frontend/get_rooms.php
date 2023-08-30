<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db_connection.php';

$sql = "select * from rooms";
$result = $conn->query($sql);

$rooms = array();
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

echo json_encode($rooms);
?>