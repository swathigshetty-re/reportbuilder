<?php
$servername = "localhost";
$dbname = "report_system";
$username = "root";
$password = "";   // Default in XAMPP

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
