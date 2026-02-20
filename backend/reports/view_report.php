<?php
header("Content-Type: application/json");
require_once "../config/db.php";

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "No ID provided"]);
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT 
    r.report_id,
    r.title,
    r.status,
    r.project_role,
    u.name AS created_by_name
FROM reports r
JOIN users u ON r.created_by = u.user_id
WHERE r.report_id = $id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} else {
    echo json_encode(["status" => "error", "message" => "Report not found"]);
}

mysqli_close($conn);
?>
