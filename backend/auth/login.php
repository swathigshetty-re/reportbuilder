<?php
require "../config/db.php";   // Adjust path if needed

header("Content-Type: application/json");

// Get JSON input
$data = json_decode(file_get_contents("php://input"));

// Check if data received
if (!$data || !isset($data->email) || !isset($data->password)) {
    echo json_encode(["status" => "invalid request"]);
    exit;
}

$email = trim($data->email);
$password = trim($data->password);

try {

    // Prepare statement
    $stmt = $conn->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
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
