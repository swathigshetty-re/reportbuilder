<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$data->email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($data->password, $user['password'])) {
    echo json_encode([
        "status" => "success",
        "user_id" => $user['user_id'],
        "role" => $user['role']
    ]);
} else {
    echo json_encode(["status" => "invalid credentials"]);
}
?>
