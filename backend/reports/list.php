<?php
require "../config/db.php";

$user_id = $_GET['user_id'];

$stmt = $conn->prepare("SELECT * FROM projects WHERE user_id=?");
$stmt->execute([$user_id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
