<?php
header("Content-Type: application/json");

require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare(
    "INSERT INTO reports 
    (titles, description, status, created_by, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?)"
);

$stmt->execute([
    $data->title,
    $data->description,
    $data->status,
    $data->created_by,
    $data->created_at,
    $data->updated_at
]);

echo json_encode(["message" => "Report added"]);
?>
