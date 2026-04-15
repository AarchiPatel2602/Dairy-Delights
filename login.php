<?php
session_start();
header("Content-Type: application/json");

// Database Connection
$conn = new mysqli("localhost", "root", "", "userdb");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Read JSON Request
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

// Check Email & Password
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["success" => false, "message" => "Missing email or password"]);
    exit();
}

$email = trim($data['email']);
$password = trim($data['password']);

// Prevent SQL Injection
$email = $conn->real_escape_string($email);

// Fetch user from DB
$stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Invalid email or password"]);
    exit();
}

$user = $result->fetch_assoc();

// Verify Password
if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];

    echo json_encode([
        "success" => true,
        "message" => "Login successful",
        "user" => [
            "id" => $user['id'],
            "name" => $user['full_name'],
            "email" => $user['email']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid email or password"]);
}

// Close Connection
$stmt->close();
$conn->close();
?>
