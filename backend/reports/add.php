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

    // Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO reports (title, description, status, created_by) VALUES (?, ?, ?, ?)");

$stmt->bind_param("sssi", $title, $description, $status, $created_by);

// Execute query
if ($stmt->execute()) {
    echo "Report added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
}
?>