<?php
session_start();
<?php session_start(); ?>
<header>
    <?php echo $_SESSION['name']; ?> – View Reports
</header>


// ✅ Check if user logged in (correct session name)
if (!isset($_SESSION['name'])) {
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

// Output table rows only (View Only)
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['report_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['progress']) . "%</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No reports found</td></tr>";
}

$conn->close();
?>
