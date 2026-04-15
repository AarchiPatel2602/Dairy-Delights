<?php
include('db1.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch order data
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_name = $_POST['product_name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $total_price = $_POST['total_price'];
            $payment_method = $_POST['payment_method'];
            $order_date = $_POST['order_date'];
            $status = $_POST['status'];

            // Update order details
            $update_stmt = $conn->prepare("UPDATE orders SET product_name = ?, price = ?, quantity = ?, total_price = ?, payment_method = ?, order_date = ?, status = ? WHERE id = ?");
            $update_stmt->bind_param("sdissssi", $product_name, $price, $quantity, $total_price, $payment_method, $order_date, $status, $order_id);

            if ($update_stmt->execute()) {
                echo "<script>alert('Order updated successfully!'); window.location.href='manage_orders.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error updating order: " . $conn->error . "');</script>";
            }
        }
    } else {
        $error_message = "Order not found.";
    }
} else {
    header('Location: manage_orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
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
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #44475a;
            color: white;
            font-size: 16px;
        }

        input:focus, select:focus {
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
        }

        button:hover {
            background: #218838;
        }

        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }

        .back-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Edit Order</h2>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (isset($order)): ?>
        <form action="edit_order.php?id=<?php echo $order['id']; ?>" method="POST">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($order['product_name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($order['price']); ?>" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" required>

            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" step="0.01" value="<?php echo htmlspecialchars($order['total_price']); ?>" required>

            <label for="payment_method">Payment Method:</label>
            <input type="text" id="payment_method" name="payment_method" value="<?php echo htmlspecialchars($order['payment_method']); ?>" required>

            <label for="order_date">Order Date & Time:</label>
            <input type="datetime-local" id="order_date" name="order_date" value="<?php echo date('Y-m-d\TH:i', strtotime($order['order_date'])); ?>" required>

            <label for="status">Order Status:</label>
            <select id="status" name="status" required>
                <option value="Ordered" <?php if ($order['status'] == 'Ordered') echo 'selected'; ?>>Ordered</option>
                <option value="Dispatched" <?php if ($order['status'] == 'Dispatched') echo 'selected'; ?>>Dispatched</option>
                <option value="Shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                <option value="Out for Delivery" <?php if ($order['status'] == 'Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
            </select>

            <button type="submit">✔ Update Order</button>
        </form>
    <?php else: ?>
        <p>Order not found.</p>
    <?php endif; ?>

    <a href="manage_orders.php" class="back-button">⬅ Back to Orders</a>
</div>

</body>
</html>
