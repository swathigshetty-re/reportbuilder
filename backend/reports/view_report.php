<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "report_system");

if ($conn->connect_error) {
    echo json_encode(["status" => "error"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "not_found"]);
    exit();
}

$report_id = intval($_GET['id']);

/* Get main report */
$reportResult = $conn->query("SELECT * FROM reports WHERE report_id = $report_id");

if ($reportResult->num_rows == 0) {
    echo json_encode(["status" => "not_found"]);
    exit();
}

$report = $reportResult->fetch_assoc();

/* Get comments */
$commentsResult = $conn->query("SELECT * FROM comments WHERE report_id = $report_id ORDER BY comment_date DESC");
$comments = [];

while ($row = $commentsResult->fetch_assoc()) {
    $comments[] = $row;
}

/* Get status history */
$statusResult = $conn->query("SELECT * FROM status_history WHERE report_id = $report_id ORDER BY updated_at DESC");
$status_history = [];

while ($row = $statusResult->fetch_assoc()) {
    $status_history[] = $row;
}

/* Final JSON */
echo json_encode([
    "report" => $report,
    "comments" => $comments,
    "status_history" => $status_history
]);
