<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$report_id = $data['report_id'] ?? '';

if (empty($report_id)) {
    echo json_encode(["status" => "error"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM reports WHERE report_id = ?");
$stmt->bind_param("i", $report_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
