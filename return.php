<?php
session_start();
include('db1.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "You need to be logged in to return a product."]);
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID
$product_id = $_POST['product_id'];
$fault_description = $_POST['fault_description'];

// Process the uploaded image
if (isset($_FILES['fault_image']) && $_FILES['fault_image']['error'] == 0) {
    // Specify the directory where the image will be uploaded
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['fault_image']['name']);

    // Check if the file is a valid image
    $image_file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
    if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo json_encode(["success" => false, "message" => "Only image files in jpg, jpeg, png, gif are allowed."]);
        exit();
    }

    // Move the uploaded file to the server
    if (move_uploaded_file($_FILES['fault_image']['tmp_name'], $upload_file)) {
        // Insert the return request into the database
        $query = "INSERT INTO product_returns (user_id, product_id, fault_description, fault_image) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiss', $user_id, $product_id, $fault_description, $upload_file);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Your return request has been submitted."]);
        } else {
            echo json_encode(["success" => false, "message" => "There was an error processing your return request."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload the image."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Please upload an image of the fault."]);
}

$conn->close();
?>
