<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "report_system");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed"]);
    exit();
}

$sql = "SELECT * FROM reports ORDER BY created_at DESC";
$result = $conn->query($sql);

$reports = [];

while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $reports
]);

$conn->close();
?>
