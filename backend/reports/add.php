<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare(
    "INSERT INTO reports (project_id, objectives, scope, outcome)
     VALUES (?, ?, ?, ?)"
);
$stmt->execute([
    $data->project_id,
    $data->objectives,
    $data->scope,
    $data->outcome
]);

echo json_encode(["message" => "Report added"]);
?>
