<?php
header("Content-Type: application/json");
require_once "../config/db.php";

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

$name     = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');
$role     = trim($data['role'] ?? '');

if (empty($name) || empty($password) || empty($role)) {
    echo json_encode(["status" => "empty"]);
    exit;
}

// Check if user already exists
$check = $conn->prepare("SELECT user_id FROM users WHERE name = ?");
$check->bind_param("s", $name);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["status" => "exists"]);
    $check->close();
    $conn->close();
    exit;
}

$check->close();

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (role, name, password, is_first_login) VALUES (?, ?, ?, 1)");
$stmt->bind_param("sss", $role, $name, $hashedPassword);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "user_id" => $stmt->insert_id,
        "role" => $role
    ]);

} else {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
}

$stmt->close();
$conn->close();
?>
