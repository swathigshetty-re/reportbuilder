<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO users (name, email, password, role)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $data->name,
    $data->email,
    password_hash($data->password, PASSWORD_DEFAULT),
    $data->role
]);

echo json_encode(["message" => "User registered successfully"]);
?>
