<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['name'])) {
    echo json_encode([
        "status" => "success",
        "name"   => $_SESSION['name'],
        "role"   => $_SESSION['role']
    ]);
} else {
    echo json_encode(["status" => "error"]);
}
