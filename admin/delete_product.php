<?php
// Include the database connection
include('db.php');

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    // Execute the query and check if deletion was successful
    if ($stmt->execute()) {
        // Redirect to the manage products page after successful deletion
        header('Location: manage_products.php');
        exit();
    } else {
        // Show error message if deletion fails
        echo "Error deleting product: " . $conn->error;
    }
} else {
    // If no ID is passed, redirect to manage products page
    header('Location: manage_products.php');
    exit();
}
?>
