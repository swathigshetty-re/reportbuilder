<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$title        = trim($data['title'] ?? '');
$description  = trim($data['description'] ?? '');
$project_role = trim($data['project_role'] ?? '');
$status       = trim($data['status'] ?? '');

if (empty($status)) {
    $status = "Pending";
}

$created_by = (int) $_SESSION['user_id'];

if (empty($title)) {
    echo json_encode(["status" => "error", "message" => "Title required"]);
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
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
