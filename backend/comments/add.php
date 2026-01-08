<?php
require "../config/db.php";

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare(
    "INSERT INTO comments (project_id, comment)
     VALUES (?, ?)"
);
$stmt->execute([
    $data->project_id,
    $data->comment
]);

echo json_encode(["message" => "Comment added"]);
?>
