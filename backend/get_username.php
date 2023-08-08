<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
session_start();
echo json_encode(['username' => $_SESSION['username']]);
?>