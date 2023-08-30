<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db_connection.php';

function getRooms() {
    include 'db_connection.php';
    $sql = "select * from rooms";
    $result = $conn->query($sql);

    $rooms = array();
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    return $rooms;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $rooms = getRooms();
    echo json_encode($rooms);
}

if (isset($_GET['roomName'])) {
    $roomName = $_GET['roomName'];
    $sql = "select * from messages where rName = '$roomName'";
    $res = $conn->query($sql);

    if ($res) {
        $messages = array();
        while ($row = $res->fetch_assoc()) {
            $messages[] = $row;
        }

        var_dump($messages);

        header('Content-type: application/json');
        echo json_encode($messages);
    } else {
        echo json_encode(['error' => 'falied to fetch messages']);
    }
}
?>