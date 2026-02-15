<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

$sql = "
SELECT 
    r.report_id,
    r.title,
    r.description,
    r.status,
    u.name AS created_by_name,
    r.created_at
FROM reports r
JOIN users u ON r.created_by = u.user_id
ORDER BY r.report_id DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
    exit;
}

$reports = [];

while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

echo json_encode($reports);

$conn->close();
