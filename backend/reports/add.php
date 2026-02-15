<?php
header("Content-Type: application/json");
require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$title       = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$status      = trim($data['status'] ?? '');

if (empty($title) || empty($status)) {
    echo json_encode(["status" => "error", "message" => "Required fields missing"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO reports (title, description, status) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $description, $status);

if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Report added successfully"
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => "Database error"
    ]);
}

$stmt->close();
$conn->close();
<<<<<<< HEAD
=======
}
>>>>>>> 2030298f3d168baa69ae18f4f960b43dc2f835f3
?>
