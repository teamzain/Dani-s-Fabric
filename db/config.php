<?php
// Database connection (adjust as needed)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dani_fabric"; // Change to your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>