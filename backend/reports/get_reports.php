<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$sql = "SELECT r.report_id, r.title, r.status
        FROM reports r
        ORDER BY r.report_id DESC";

$result = $conn->query($sql);

$reports = [];

while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

echo json_encode($reports);
$conn->close();
?>
