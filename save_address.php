<?php
include 'db1.php'; // your DB config

header('Content-Type: application/json');

$user_id = $_POST['user_id'];
$fullname = $_POST['fullname'];
$house = $_POST['house'];
$street = $_POST['street'];
$area = $_POST['area'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$state = $_POST['state'];

if (!$user_id || !$fullname || !$house || !$city || !$pincode) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Check if address already exists
$check = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
$check->bind_param("i", $user_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Update existing address
    $stmt = $conn->prepare("UPDATE addresses SET fullname=?, house=?, street=?, area=?, city=?, pincode=?, state=? WHERE user_id=?");
    $stmt->bind_param("sssssssi", $fullname, $house, $street, $area, $city, $pincode, $state, $user_id);
} else {
    // Insert new address
    $stmt = $conn->prepare("INSERT INTO addresses (user_id, fullname, house, street, area, city, pincode, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $fullname, $house, $street, $area, $city, $pincode, $state);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'DB error']);
}

$conn->close();
?>
