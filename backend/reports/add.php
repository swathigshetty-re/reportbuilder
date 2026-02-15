<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "report_system");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo "Form submitted!<br>"; // Debug line
    
    // Get form data and check if they exist
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    
    echo "Title: $title<br>"; // Debug line
    echo "Description: $description<br>"; // Debug line
    echo "Status: $status<br>"; // Debug line

    // Temporary user id
    $created_by = 1;

    // Insert query
    $sql = "INSERT INTO reports (title, description, status, created_by) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("sssi", $title, $description, $status, $created_by);

    if ($stmt->execute()) {
        echo "Record inserted successfully!<br>"; // Debug line
        $stmt->close();
        $conn->close();
        
        echo "Redirecting to admin dashboard..."; // Debug line
        // Uncomment the line below once debugging is done
        // header("Location: admin_dashboard.html");
        // exit();
    } else {
        echo "Execute Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Form not submitted via POST";
}

$conn->close();
}
?>
