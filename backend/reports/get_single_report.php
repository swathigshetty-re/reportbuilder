<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$report_id = $_GET['id'] ?? '';

if (empty($report_id)) {
    echo json_encode(["status" => "error"]);
    exit;
}

$stmt = $conn->prepare("
SELECT 
    r.title,
    r.project_role,
    r.description,
    r.status,
    u.name AS created_by_name,
    u.role AS created_by_role,
    r.created_at
FROM reports r
JOIN users u ON r.created_by = u.user_id
WHERE r.report_id = ?
");


$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["status" => "not_found"]);
}

$stmt->close();
$conn->close();
