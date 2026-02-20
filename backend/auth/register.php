<?php
header("Content-Type: application/json");
session_start();

$conn = new mysqli("localhost", "root", "", "report_system");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name']) || !isset($data['password']) || !isset($data['role'])) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

$name = $data['name'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$role = $data['role'];

// Check if user already exists
$check = $conn->prepare("SELECT user_id FROM users WHERE name = ?");
$check->bind_param("s", $name);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["status" => "exists"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $password, $role);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;

    echo json_encode([
        "status" => "success",
        "user_id" => $user_id,
        "role" => $role
    ]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
