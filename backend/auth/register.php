<?php
require "../backend/config/db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? "";
$password = $data->password ?? "";
$role = $data->role ?? "";

if ($username == "" || $password == "") {
    echo json_encode(["status" => "empty"]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $role]);

    echo json_encode(["status" => "success"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "exists"]);
}
?>
