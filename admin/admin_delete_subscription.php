<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dairy_products";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get subscription ID from URL
$subscription_id = $_GET['id'] ?? null;

if (!$subscription_id) {
    die("No subscription ID provided.");
}

// Delete subscription from database
$sql_delete = "DELETE FROM subscriptions WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $subscription_id);

if ($stmt_delete->execute()) {
    header("Location: admin_view_subscriptions.php?status=deleted");
    exit();
} else {
    echo "Error: " . $stmt_delete->error;
}

$stmt_delete->close();
$conn->close();
?>
