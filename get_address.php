<?php
include 'db1.php'; // Your DB config

header('Content-Type: application/json');

$user_id = $_GET['user_id'];

$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'address' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Address not found']);
}

$conn->close();
?>
