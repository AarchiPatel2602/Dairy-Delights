<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db.php');
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description']; // Get the description from the form

    // Check if the ID already exists
    $check_stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Error: ID already exists. Choose a different ID.');</script>";
    } else {
        // Insert query to add the new product with description
        $stmt = $conn->prepare("INSERT INTO products (id, name, price, image, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id, $name, $price, $image, $description);
        
        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!'); window.location.href='manage_products.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error inserting product: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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

        input, textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #44475a;
            color: white;
            font-size: 16px;
        }

        input:focus, textarea:focus {
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
            margin-bottom: 15px;
        }

        .back-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🛒 Add New Product</h2>

        <!-- Back to Products Button -->
        <a href="manage_products.php" class="back-button">⬅ Back to Products</a>

        <form action="add_product.php" method="POST">
            <label for="id">Product ID:</label>
            <input type="number" id="id" name="id" required>

            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>
            
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" required>

            <label for="description">Product Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit">➕ Add Product</button>
        </form>
    </div>

</body>
</html>
