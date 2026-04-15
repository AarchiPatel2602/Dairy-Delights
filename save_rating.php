<?php
session_start();
header("Content-Type: application/json");

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "userdb";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Retrieve Data from POST Request
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

// Validate Input
if ($user_id <= 0 || empty($email) || $rating < 1 || $rating > 5) {
    echo json_encode(["success" => false, "message" => "Invalid input data provided."]);
    exit();
}

// Fetch Username from Session or Database
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (empty($username)) {
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
        exit();
    }
}

// Check if User Already Rated
$stmt = $conn->prepare("SELECT id FROM user_ratings WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $rating_exists = $stmt->num_rows > 0;
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
    exit();
}

if ($rating_exists) {
    // Update Existing Rating
    $stmt = $conn->prepare("UPDATE user_ratings SET rating = ?, updated_at = NOW() WHERE user_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $rating, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Rating updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating rating: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
    }
} else {
    // Insert New Rating
    $stmt = $conn->prepare("INSERT INTO user_ratings (user_id, username, email, rating, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    if ($stmt) {
        $stmt->bind_param("issi", $user_id, $username, $email, $rating);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Rating saved successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error inserting rating: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
    }
}

// Close Database Connection
$conn->close();
?>
