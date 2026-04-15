<?php
include('db.php');

$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style> 
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e2f;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            color: #f8f8f2;
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Admin Panel and Add Product Buttons */
        .admin-button, .add-product-link {
            margin-bottom: 20px;
        }

        .btn {
            background: #007BFF;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background 0.3s;
            display: inline-block;
        }

        .btn:hover {
            background: #0056b3;
        }

        /* Table Styling */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-table thead {
            background: #007BFF;
            color: white;
        }

        .product-table th, .product-table td {
            padding: 12px;
            border: 1px solid #444;
            text-align: center;
        }

        .product-table tbody tr {
            background: #44475a;
            transition: background 0.3s;
        }

        .product-table tbody tr:hover {
            background: #6272a4;
        }

        /* Product Image */
        .product-table img {
            border-radius: 5px;
            width: 50px;
            height: auto;
        }

        /* Action Buttons */
        .actions a {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin: 3px;
            display: inline-block;
        }

        .btn-edit {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back to Admin Panel Button -->
        <div class="admin-button">
            <a href="admin_panel.php" class="btn">⬅ Back to Admin Panel</a>
        </div>

        <h2>🛒 Manage Products</h2>

        <!-- Add New Product Link -->
        <div class="add-product-link">
            <a href="add_product.php" class="btn">➕ Add New Product</a>
        </div>

        <!-- Products Table -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th> <!-- Add this column -->
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></t>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['description'] ?? ''); ?></td> <!-- Handle null description -->
                        <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image"></td>
                        <td class="actions">
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn-edit">✏ Edit</a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?');">🗑 Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>