<?php
session_start();

// Check if viewer logged in
if (!isset($_SESSION['viewer_name'])) {
    header("Location: ../login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "report_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM reports 
            WHERE title LIKE '%$search%' 
            OR description LIKE '%$search%' 
            ORDER BY report_id DESC";
} else {
    $sql = "SELECT * FROM reports ORDER BY report_id DESC";
}

$result = $conn->query($sql);

// Output table rows only
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['report_id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['progress'] . "%</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No reports found</td></tr>";
}

$conn->close();
?>
