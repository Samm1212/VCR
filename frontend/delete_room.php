<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit();
}
include '../backend/db_connection.php';

$rName = $_POST['rName'];
$sql = "delete from rooms where rName = '$rName';";
$res = $conn->query($sql);
?>