<?php
include('db.php');

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Query to get product details
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header('Location: manage_products.php');
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_id = $_POST['new_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];  // Get the new description

    // Check if the new ID is unique
    $check_query = "SELECT id FROM products WHERE id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("i", $new_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0 && $new_id != $product_id) {
        echo "<script>alert('Error: ID already exists. Choose a different ID.');</script>";
    } else {
        // Update product with new description
        $update_query = "UPDATE products SET id = ?, name = ?, price = ?, image = ?, description = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("issssi", $new_id, $name, $price, $image, $description, $product_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Product updated successfully!'); window.location.href='manage_products.php?id=$new_id';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating product: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            margin: 0;
            padding: 0;
            color: white;
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #f8f8f2;
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #44475a;
            color: white;
            font-size: 16px;
        }

        input:focus {
            outline: 2px solid #6272a4;
        }

        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        button:hover {
            background: #218838;
        }

        /* Back Button */
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
            margin-top: 15px;
        }

        .back-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>✏️ Edit Product</h2>

        <form action="edit_product.php?id=<?php echo $product['id']; ?>" method="POST">
            <label for="new_id">Product ID:</label>
            <input type="text" id="new_id" name="new_id" value="<?php echo $product['id']; ?>" required>

            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>

            <label for="price">Price: (₹)</label>
            <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" required>

            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" value="<?php echo $product['image']; ?>" required>

            <!-- Description Field -->
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <button type="submit">✔ Update Product</button>
        </form>

        <a href="manage_products.php" class="back-button">⬅ Back to Products</a>
    </div>

</body>
</html>