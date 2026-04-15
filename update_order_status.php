<?php
include 'db1.php';
header('Content-Type: application/json');

// Secure with admin session check (recommended)

$order_id = $_POST['order_id'];
$new_status = $_POST['status'];

$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("ii", $new_status, $order_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
