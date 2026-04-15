<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dairy_products";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all subscriptions from the database
$sql = "SELECT * FROM subscriptions ORDER BY start_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Subscriptions</title>
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

        /* Admin Panel and Add Subscription Link */
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

        /* Back Button */
        .back-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2>🛒 Manage Subscriptions</h2>
        <!-- Subscriptions Table -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Frequency</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['frequency']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="actions">
                                <a href="admin_edit_subscription.php?id=<?php echo $row['id']; ?>" class="btn-edit">✏ Edit</a>
                                <a href="admin_delete_subscription.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this subscription?')">🗑 Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No subscriptions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Back to Dashboard Button -->
        <div class="button-container">
            <a href="admin_panel.php" class="back-btn">⬅ Back to Admin Panel</a>
        </div>

    </div>

</body>
</html>

<?php
$conn->close();
?>
