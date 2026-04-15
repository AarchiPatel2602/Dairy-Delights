<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "dairy_products";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $review_id = $_POST["review_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $sql = "UPDATE feedback SET name = ?, email = ?, message = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $message, $review_id);

    if ($stmt->execute()) {
        header("Location: reviews.php");
        exit();
    } else {
        echo "Error updating review.";
    }

    $stmt->close();
}

$conn->close();
?>
