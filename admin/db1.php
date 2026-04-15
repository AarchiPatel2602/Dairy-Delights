<?php
// Database connection details
$servername = "localhost"; // Your MySQL server (usually localhost)
$username = "root";        // Your MySQL username (usually root)
$password = "";            // Your MySQL password (usually empty for localhost)
$dbname = "dairy_products";   // The correct database name (dairy_order)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
