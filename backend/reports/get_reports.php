<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$sql = "SELECT report_id, title, description, status, created_at FROM reports ORDER BY created_at DESC";

$result = $conn->query($sql);

$reports = [];

while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

echo json_encode($reports);

$conn->close();
?>