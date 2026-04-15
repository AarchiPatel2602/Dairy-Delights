<?php
include('db1.php'); // Include the database connection file

// Check if the 'id' parameter is passed
if (isset($_GET['id'])) {
    $subscription_id = $_GET['id'];

    // Query to delete the subscription from the database
    $sql = "DELETE FROM subscriptions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subscription_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Subscription deleted successfully!'); window.location.href='your_subscriptions.php';</script>";
        exit();
    } else {
        echo "Error deleting subscription: " . $stmt->error;
    }
} else {
    echo "Invalid request: Missing subscription ID.";
}

$stmt->close();
$conn->close();
?>
