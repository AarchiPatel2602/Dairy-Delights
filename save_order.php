<?php
header("Content-Type: application/json");

// Capture JSON input
$json = file_get_contents("php://input");

// Log received data
file_put_contents("log.txt", "Received JSON: " . $json . PHP_EOL, FILE_APPEND);

$data = json_decode($json, true);

// Validate data
if (!$data || !isset($data['products']) || !isset($data['paymentMethod']) || !isset($data['user_id'])) {
    echo json_encode(["error" => "Invalid order data"]);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Fetch username using user_id
$user_id = $data['user_id'];
$username = '';

$userQuery = $conn->prepare("SELECT username FROM users WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userRow = $userResult->fetch_assoc()) {
    $username = $userRow['username'];
} else {
    echo json_encode(["error" => "User not found"]);
    exit;
}
$userQuery->close();

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO orders (user_id, username, product_name, price, quantity, total_price, payment_method, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

if (!$stmt) {
    echo json_encode(["error" => "SQL error: " . $conn->error]);
    exit;
}

// Insert each product
foreach ($data['products'] as $product) {
    $stmt->bind_param("issdiis", 
        $user_id,
        $username,
        $product['name'], 
        $product['price'], 
        $product['quantity'], 
        $product['total'], 
        $data['paymentMethod']
    );

    if (!$stmt->execute()) {
        echo json_encode(["error" => "Insert error: " . $stmt->error]);
        exit;
    }
}

$stmt->close();
$conn->close();

echo json_encode(["success" => "Order stored successfully"]);
?>
