<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$customer_name = $_POST['name']; // Ensure it matches the form field
$email = $_POST['email'];
$feedback = $_POST['message']; // Ensure it matches the form field

// Prepare and bind to prevent SQL Injection
$stmt = $conn->prepare("INSERT INTO feedback (customer_name, email, feedback) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $customer_name, $email, $feedback);

// Execute and redirect
if ($stmt->execute()) {
    echo "<script>alert('Feedback submitted successfully!'); window.location.href='HOME.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
