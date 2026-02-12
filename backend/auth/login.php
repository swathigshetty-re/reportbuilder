<?php
require "../backend/config/db.php";   // Adjust path if needed

header("Content-Type: application/json");

// Get JSON input
$data = json_decode(file_get_contents("php://input"));

// Check if data received
if (!$data || !isset($data->username) || !isset($data->password)) {
    echo json_encode(["status" => "invalid request"]);
    exit;
}

$username = trim($data->username);
$password = trim($data->password);

try {

    // Prepare statement
    $stmt = $conn->prepare("SELECT user_id, username, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user and password
    if ($user && password_verify($password, $user['password'])) {

        echo json_encode([
            "status" => "success",
            "user_id" => $user['user_id'],
            "role" => $user['role']
        ]);

    } else {
        echo json_encode([
            "status" => "invalid credentials"
        ]);
    }

} catch (PDOException $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>
