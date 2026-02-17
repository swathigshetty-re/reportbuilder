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

$sql = "SELECT * FROM reports WHERE report_id = $id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} else {
    echo json_encode(["status" => "error", "message" => "Report not found"]);
}

mysqli_close($conn);
?>
