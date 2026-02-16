<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$title       = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$status      = trim($data['status'] ?? '');
$project_role = trim($data['project_role'] ?? '');

$created_by = $_SESSION['user_id']; // 🔥 REAL USER

if (empty($title) || empty($status)) {
    echo json_encode(["status" => "error", "message" => "Required fields missing"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO reports (title, project_role, description, status, created_by)
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param("ssssi", $title, $project_role, $description, $status, $created_by);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$stmt->close();
$conn->close();
