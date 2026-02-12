<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$name     = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if (empty($name) || empty($password)) {
    echo json_encode(["status" => "error"]);
    exit;
}

$stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        echo json_encode([
            "status"  => "success",
            "user_id" => $user['user_id'],
            "role"    => $user['role']
        ]);

    } else {
        echo json_encode(["status" => "error"]);
    }

} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
