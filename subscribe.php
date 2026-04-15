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

// Get form data
$product_name = $_POST['product_name'];
$quantity = $_POST['quantity'];
$frequency = $_POST['frequency'];
$user_id = 1; // Use session or other methods to get actual user ID

// Calculate the next delivery date based on the frequency
$next_delivery_date = '';
switch($frequency) {
    case 'weekly':
        $next_delivery_date = date('Y-m-d', strtotime('+1 week'));
        break;
    case 'bi-weekly':
        $next_delivery_date = date('Y-m-d', strtotime('+2 weeks'));
        break;
    case 'monthly':
        $next_delivery_date = date('Y-m-d', strtotime('+1 month'));
        break;
    default:
        $next_delivery_date = date('Y-m-d'); // Default to today's date
        break;
}

// Assign the start date
$start_date = date('Y-m-d');  // Current date

// Insert the subscription into the database
$sql = "INSERT INTO subscriptions (user_id, product_name, quantity, frequency, next_delivery_date, start_date, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Bind parameters
$status = 'active'; // Set the subscription status to 'active'
$stmt->bind_param("isissss", $user_id, $product_name, $quantity, $frequency, $next_delivery_date, $start_date, $status);

// Execute and check if the statement was successful
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);  // Return success response as JSON
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);  // Return error response as JSON
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
