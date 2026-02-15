<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$name     = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if (empty($name) || empty($password)) {
    echo json_encode(["status" => "error"]);
    exit;
}

$stmt = $conn->prepare("SELECT user_id, name, password, role FROM users WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        // 🔥 STORE SESSION
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];

        echo json_encode([
            "status" => "success"
        ]);

    } else {
        echo json_encode(["status" => "error"]);
    }

} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
