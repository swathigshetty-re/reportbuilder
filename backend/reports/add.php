<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare(
    "INSERT INTO reports (report_id, titles, description, status, created_by, created_at, updated_at)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->execute([
    $data->report_id,
    $data->title,
    $data->description,
    $data->status,
    $data->created_by,
    $data->created_at,
    $data->updated_at

]);

echo json_encode(["message" => "Report added"]);
?>
