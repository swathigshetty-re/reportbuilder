<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO projects 
(user_id, title, status,  description, start_date, end_date)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $data->user_id,
    $data->title,
    $data->status,
    $data->description,
    $data->start_date,
    $data->end_date,

]);

echo json_encode(["message" => "Project created"]);
?>
