<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$title       = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$status      = trim($data['status'] ?? '');

if (empty($title) || empty($status)) {
    echo json_encode([
        "status" => "error",
        "message" => "Required fields missing"
    ]);
    exit;
}

$created_by = 1; // make sure user_id = 1 exists in users table

$stmt = $conn->prepare(
    "INSERT INTO reports (title, description, status, created_by) VALUES (?, ?, ?, ?)"
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
