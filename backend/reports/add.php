<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$title       = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$status      = trim($data['status'] ?? '');

$created_by = 3; // 🔥 change this to EXISTING user_id

if (empty($title) || empty($status)) {
    echo json_encode([
        "status" => "error",
        "message" => "Required fields missing"
    ]);
    echo json_encode(["test_user_id" => $created_by]);

    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO reports (title, description, status, created_by)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("sssi", $title, $description, $status, $created_by);

if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Report added successfully"
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => $conn->error
    ]);
}

$stmt->close();
$conn->close();
