<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is installed via Composer

include('db_connection.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

$json_data = file_get_contents("php://input");

if (!$json_data || empty(trim($json_data))) {
    die(json_encode(["success" => false, "message" => "No data received."]));
}

$data = json_decode($json_data, true);

if (!$data || !isset($data['full_name']) || !isset($data['email']) || !isset($data['password'])) {
    die(json_encode(["success" => false, "message" => "Missing required fields."]));
}

$email = $data['email'];

// Check if the email already exists
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email id already taken"]);
    $stmt->close();
    $conn->close();
    exit();
}

$password_hash = password_hash($data['password'], PASSWORD_BCRYPT);

// Insert user into the database
$query = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $data['full_name'], $data['email'], $password_hash);

if ($stmt->execute()) {
    // Send Welcome Email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dairydelights2602@gmail.com'; // Your Gmail
        $mail->Password = 'verkbntclewxcewa'; // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Headers
        $mail->setFrom('dairydelights2602@gmail.com', 'Dairy Delights');
        $mail->addAddress($email, $data['full_name']);
        $mail->isHTML(true);
        $mail->Subject = "Welcome to Dairy Delights!";
        $mail->Body = "<h2>Welcome, " . htmlspecialchars($data['full_name']) . "!</h2>
                      <p>Thank you for signing up with Dairy Delights.</p>
                      <p>We’re excited to have you with us!</p>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Signup email error: " . $mail->ErrorInfo); // Log error instead of showing it
    }

    echo json_encode(["success" => true, "message" => "User registered successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to register user."]);
}

$stmt->close();
$conn->close();
?>
