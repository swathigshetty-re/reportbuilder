<?php
header("Content-Type: application/json");

include("../config/database.php");

$sql = "SELECT * FROM reports ORDER BY id DESC";
$result = $conn->query($sql);

$reports = [];

while($row = $result->fetch_assoc()){
    $reports[] = $row;
}

echo json_encode($reports);

$conn->close();
?>
